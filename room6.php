<?php
include 'connection.php';

$room_id = 6;

$stmt = $conn->prepare("SELECT room_id, room_name, price_per_night, image_path FROM rooms WHERE room_id = ?");
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();
$room = $result->fetch_assoc();
$stmt->close();

if (!$room) {
    $room = [
        'room_id' => 6,
        'room_name' => 'Economy Twin Room',
        'price_per_night' => 3000,
        'image_path' => 'assets/images/economy_2.jpg'
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($room['room_name']); ?></title>
    <link rel="stylesheet" href="room1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <!-- Hero -->
    <div class="room1_hero">
        <p>Our Rooms</p>
        <h1><?php echo htmlspecialchars($room['room_name']); ?></h1>
        <div id="hero_sub">"Two beds, budget-friendly rates — great for friends travelling together."</div>
    </div>

    <!-- Room details -->
    <div class="room1_body">

        <div class="room1_gallery">
            <img src="<?php echo htmlspecialchars($room['image_path']); ?>" alt="<?php echo htmlspecialchars($room['room_name']); ?>">
        </div>

        <div class="room1_info">
            <div class="room1_info_head">
                <h2><?php echo htmlspecialchars($room['room_name']); ?></h2>
                <div class="room1_price">
                    <span class="amount">₹<?php echo number_format($room['price_per_night'], 0); ?></span>
                    <span class="per">/ night</span>
                </div>
            </div>

            <p class="room1_desc">
                The Economy Twin Room pairs two comfortable single beds with simple, clean decor —
                a practical choice for friends or colleagues who want their own space without paying
                for extras they won't use.
            </p>

            <div class="room1_features">
                <div class="feature"><i class="fa-solid fa-bed"></i><span>2 Single Beds</span></div>
                <div class="feature"><i class="fa-solid fa-user-group"></i><span>2 Adults</span></div>
                <div class="feature"><i class="fa-solid fa-vector-square"></i><span>260 sq. ft.</span></div>
                <div class="feature"><i class="fa-solid fa-wifi"></i><span>Free WiFi</span></div>
                <div class="feature"><i class="fa-solid fa-snowflake"></i><span>Air Conditioning</span></div>
                <div class="feature"><i class="fa-solid fa-tv"></i><span>LED TV</span></div>
                <div class="feature"><i class="fa-solid fa-bath"></i><span>Private Bathroom</span></div>
                <div class="feature"><i class="fa-solid fa-broom"></i><span>Daily Housekeeping</span></div>
                <div class="feature"><i class="fa-solid fa-square-parking"></i><span>Free Parking</span></div>
            </div>

            <div class="room1_book_btn">
                <a href="book_room.php?room_id=<?php echo $room['room_id']; ?>">
                    <button>Book This Room</button>
                </a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>