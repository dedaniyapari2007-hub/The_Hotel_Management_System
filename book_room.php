<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
include 'connection.php';

// ---------- 1. Get the room this booking is for ----------
$room_id = isset($_GET['room_id']) ? (int) $_GET['room_id'] : 0;

$room = null;
if ($room_id > 0) {
    $stmt = $conn->prepare("SELECT room_id, room_name, price_per_night, image_path FROM rooms WHERE room_id = ?");
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $room = $result->fetch_assoc();
    $stmt->close();
}

// If no valid room was passed in, don't let the form submit
$room_missing = ($room === null);

// ---------- 2. Handle the form submission ----------
$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$room_missing && isset($_SESSION['email'])) {

    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $check_in   = $_POST['check_in'] ?? '';
    $check_out  = $_POST['check_out'] ?? '';

    // --- validation ---
    if ($first_name === '' || $last_name === '') {
        $errors[] = "Please enter your first and last name.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if ($phone === '') {
        $errors[] = "Please enter a phone number.";
    }
    if ($check_in === '' || $check_out === '') {
        $errors[] = "Please select check-in and check-out dates.";
    } else {
        $ci = DateTime::createFromFormat('Y-m-d', $check_in);
        $co = DateTime::createFromFormat('Y-m-d', $check_out);
        if (!$ci || !$co) {
            $errors[] = "Dates are not valid.";
        } elseif ($co <= $ci) {
            $errors[] = "Check-out date must be after the check-in date.";
        } elseif ($ci < new DateTime('today')) {
            $errors[] = "Check-in date cannot be in the past.";
        }
    }

    // --- if clean, save it ---
    if (empty($errors)) {
        $nights = (int) $ci->diff($co)->days;
        $total_amount = $nights * (float) $room['price_per_night'];

        // find an existing guest by email, otherwise create one
        $stmt = $conn->prepare("SELECT guest_id FROM guests WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $guestResult = $stmt->get_result();
        $stmt->close();

        if ($guestRow = $guestResult->fetch_assoc()) {
            $guest_id = $guestRow['guest_id'];
        } else {
            $stmt = $conn->prepare("INSERT INTO guests (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $first_name, $last_name, $email, $phone);
            $stmt->execute();
            $guest_id = $stmt->insert_id;
            $stmt->close();
        }

        // create the booking
        $stmt = $conn->prepare("INSERT INTO bookings (guest_id, room_id, check_in_date, check_out_date, total_amount, status) VALUES (?, ?, ?, ?, ?, 'confirmed')");
        $stmt->bind_param("iissd", $guest_id, $room_id, $check_in, $check_out, $total_amount);

        if ($stmt->execute()) {
            $success = true;
            $booking_id = $stmt->insert_id;
        } else {
            $errors[] = "Something went wrong while saving your booking. Please try again.";
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Your Room</title>
    <link rel="stylesheet" href="book_room.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!-- Hero -->
    <div class="booking_hero">
        <p>Reserve Your Stay</p>
        <h1><?php echo $room_missing ? 'Book Your Room' : htmlspecialchars($room['room_name']); ?></h1>
        <div id="hero_sub">"Just a few details and your room will be waiting for you."</div>
    </div>

    <div class="booking_body">

        <?php if (!isset($_SESSION['email'])): ?>

            <div class="booking_message error">
                <h2>Login Required</h2>
                <p>You must be logged in to book a room. Please login or sign up first.</p>
                <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: center;">
                    <a href="login.php"><button>Login</button></a>
                    <a href="register.php"><button style="background-color: #333;">Sign Up</button></a>
                </div>
            </div>

        <?php elseif ($room_missing): ?>

            <div class="booking_message error">
                <p>We couldn't find that room. Please go back and choose a room again.</p>
                <a href="our_rooms.php"><button>Back to Rooms</button></a>
            </div>

        <?php elseif ($success): ?>

            <div class="booking_message success">
                <i class="fa-solid fa-circle-check"></i>
                <h2>Booking Confirmed!</h2>
                <p>Thank you, <?php echo htmlspecialchars($first_name); ?>. Your booking reference is <strong>#<?php echo $booking_id; ?></strong>.</p>
                <p><?php echo htmlspecialchars($room['room_name']); ?> &middot; <?php echo htmlspecialchars($check_in); ?> to <?php echo htmlspecialchars($check_out); ?> &middot; ₹<?php echo number_format($total_amount, 2); ?> total</p>
                <a href="our_rooms.php"><button>Back to Rooms</button></a>
            </div>

        <?php else: ?>

            <div class="booking_summary">
                <img src="<?php echo htmlspecialchars($room['image_path']); ?>" alt="<?php echo htmlspecialchars($room['room_name']); ?>">
                <div>
                    <h2><?php echo htmlspecialchars($room['room_name']); ?></h2>
                    <div class="booking_price">
                        <span class="amount">₹<?php echo number_format($room['price_per_night'], 0); ?></span>
                        <span class="per">/ night</span>
                    </div>
                </div>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="booking_message error">
                    <ul>
                        <?php foreach ($errors as $err): ?>
                            <li><?php echo htmlspecialchars($err); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form class="booking_form" method="POST" action="book_room.php?room_id=<?php echo $room_id; ?>">

                <?php 
                    $def_fname = $_SESSION['name'] ?? '';
                    $def_email = $_SESSION['email'] ?? '';
                ?>
                <div class="form_row">
                    <div class="form_group">
                        <label for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($_POST['first_name'] ?? $def_fname); ?>" required>
                    </div>
                    <div class="form_group">
                        <label for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="form_row">
                    <div class="form_group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? $def_email); ?>" <?php echo $def_email ? 'readonly' : ''; ?> required>
                    </div>
                    <div class="form_group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="form_row">
                    <div class="form_group">
                        <label for="check_in">Check-In</label>
                        <input type="date" id="check_in" name="check_in" value="<?php echo htmlspecialchars($_POST['check_in'] ?? ''); ?>" required>
                    </div>
                    <div class="form_group">
                        <label for="check_out">Check-Out</label>
                        <input type="date" id="check_out" name="check_out" value="<?php echo htmlspecialchars($_POST['check_out'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="booking_submit_btn">
                    <button type="submit" name="confirm_booking">Confirm Booking</button>
                </div>

            </form>

        <?php endif; ?>

    </div>

    <?php include 'footer.php'; ?>
</body>
</html>