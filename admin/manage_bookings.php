<?php
include '../db.php';
include 'includes/admin_auth_check.php';

if (isset($_POST['update_status'])) {
    if (!verify_csrf_token($_POST['csrf_token'])) { die("CSRF validation failed."); }
    $booking_id = (int) $_POST['booking_id'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE bookings SET status=? WHERE booking_id=?");
    $stmt->bind_param("si", $status, $booking_id);
    $stmt->execute();
    $stmt->close();
    header("Location: manage_bookings.php");
    exit;
}

include 'includes/admin_header.php';

$sql = "SELECT b.*, g.first_name, g.last_name, g.email, r.room_name 
        FROM bookings b 
        JOIN guests g ON b.guest_id = g.guest_id 
        JOIN rooms r ON b.room_id = r.room_id 
        ORDER BY b.check_in_date DESC";
$bookings = $conn->query($sql);
?>

<h1>Manage Bookings</h1>
<div class="card" style="overflow-x: auto;">
    <table class="admin-table">
        <tr>
            <th>ID</th>
            <th>Guest</th>
            <th>Room</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Total</th>
            <th>Status Update</th>
        </tr>
        <?php while($b = $bookings->fetch_assoc()): ?>
        <tr>
            <td><?= $b['booking_id'] ?></td>
            <td><?= htmlspecialchars($b['first_name'] . ' ' . $b['last_name']) ?><br><small><?= htmlspecialchars($b['email']) ?></small></td>
            <td><?= htmlspecialchars($b['room_name']) ?></td>
            <td><?= $b['check_in_date'] ?></td>
            <td><?= $b['check_out_date'] ?></td>
            <td>₹<?= number_format($b['total_amount']) ?></td>
            <td>
                <form method="POST" style="display:flex; gap: 5px;">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">
                    <input type="hidden" name="booking_id" value="<?= $b['booking_id'] ?>">
                    <select name="status" style="padding: 5px; border-radius: 4px;">
                        <option value="confirmed" <?= $b['status']=='confirmed'?'selected':'' ?>>Confirmed</option>
                        <option value="checked_in" <?= $b['status']=='checked_in'?'selected':'' ?>>Checked In</option>
                        <option value="checked_out" <?= $b['status']=='checked_out'?'selected':'' ?>>Checked Out</option>
                        <option value="cancelled" <?= $b['status']=='cancelled'?'selected':'' ?>>Cancelled</option>
                    </select>
                    <button type="submit" name="update_status" class="btn" style="padding: 4px 8px; font-size: 12px;">Save</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
<?php include 'includes/admin_footer.php'; ?>
