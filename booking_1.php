<?php
session_start();
require_once 'db.php';

// Must be logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_email = $_SESSION['email'];

// Handle a cancellation request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_booking_id'])) {
    $booking_id = (int) $_POST['cancel_booking_id'];

    // Only allow cancelling a booking that actually belongs to this user
    $stmt = $conn->prepare(
        "UPDATE bookings b
         JOIN guests g ON b.guest_id = g.guest_id
         SET b.status = 'cancelled'
         WHERE b.booking_id = ? AND g.email = ? AND b.status != 'cancelled'"
    );
    $stmt->bind_param("is", $booking_id, $user_email);
    $stmt->execute();
    $stmt->close();

    header("Location: booking_1.php");
    exit;
}

// guests.email is matched against the logged-in user's email — bookings are
// stored against a "guest" record, not a "user" record, so this is how the
// two are linked. If your booking form lets guests type a different email
// than their login email, this lookup won't find those bookings.
$stmt = $conn->prepare(
    "SELECT b.booking_id, b.check_in_date, b.check_out_date, b.total_amount, b.status,
            r.room_name, r.image_path
     FROM bookings b
     JOIN guests g ON b.guest_id = g.guest_id
     JOIN rooms r ON b.room_id = r.room_id
     WHERE g.email = ?
     ORDER BY b.check_in_date DESC"
);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$bookings = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - Platinum Palace</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .bookings-wrap { max-width: 900px; margin: 60px auto; padding: 0 20px; }
        .bookings-wrap h1 { margin-bottom: 25px; }
        .booking-card {
            display: flex; justify-content: space-between; align-items: center;
            border: 1px solid #ddd; border-radius: 8px; padding: 18px 20px; margin-bottom: 15px;
        }
        .booking-card .details h3 { margin: 0 0 8px; }
        .booking-card .details p { margin: 2px 0; color: #555; font-size: 14px; }
        .status-badge {
            display: inline-block; padding: 3px 10px; border-radius: 12px;
            font-size: 12px; font-weight: 600; text-transform: capitalize;
        }
        .status-confirmed   { background: #e6f4ea; color: #1e7e34; }
        .status-checked_in  { background: #e6f0ff; color: #1a4fb4; }
        .status-checked_out { background: #eee; color: #555; }
        .status-cancelled   { background: #fdeaea; color: #b00020; }
        .cancel-btn {
            background: #b00020; color: #fff; border: none; padding: 8px 14px;
            border-radius: 5px; cursor: pointer;
        }
        .empty-state { text-align: center; padding: 60px 20px; color: #666; }
        .empty-state a { color: #1a4fb4; }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="bookings-wrap">
        <h1>My Bookings</h1>

        <?php if ($bookings->num_rows === 0): ?>
            <div class="empty-state">
                <p>You don't have any bookings yet.</p>
                <a href="booking.php">Browse rooms and book your stay &rarr;</a>
            </div>
        <?php else: ?>
            <?php while ($row = $bookings->fetch_assoc()): ?>
                <div class="booking-card">
                    <div class="details">
                        <h3><?= htmlspecialchars($row['room_name']) ?></h3>
                        <p><?= htmlspecialchars($row['check_in_date']) ?> &rarr; <?= htmlspecialchars($row['check_out_date']) ?></p>
                        <p>Total: ₹<?= number_format($row['total_amount'], 2) ?></p>
                        <p>
                            <span class="status-badge status-<?= htmlspecialchars($row['status']) ?>">
                                <?= htmlspecialchars(str_replace('_', ' ', $row['status'])) ?>
                            </span>
                        </p>
                    </div>
                    <?php if ($row['status'] === 'confirmed'): ?>
                        <form method="POST" action="booking_1.php" onsubmit="return confirm('Cancel this booking?');">
                            <input type="hidden" name="cancel_booking_id" value="<?= $row['booking_id'] ?>">
                            <button type="submit" class="cancel-btn">Cancel</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</body>
</html>