<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platinum Premium Room</title>
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
        <h1>Platinum Premium Room</h1>
        <div id="hero_sub">"A refined escape crafted for comfort, space and quiet luxury."</div>
    </div>

    <!-- Room details -->
    <div class="room1_body">

        <div class="room1_gallery">
            <img src="assets\images\luxury_2.jpg" alt="Platinum Premium Room">
        </div>

        <div class="room1_info">
            <div class="room1_info_head">
                <h2>Platinum Premium Room</h2>
                <div class="room1_price">
                    <span class="amount">₹6,500</span>
                    <span class="per">/ night</span>
                </div>
            </div>

            <p class="room1_desc">
                Our signature Platinum Premium Room offers a spacious retreat with elegant interiors,
                a plush king-size bed and floor-to-ceiling views. Designed for guests who expect nothing
                less than absolute comfort during their stay with Platinum Palace.
            </p>

            <div class="room1_features">
                <div class="feature"><i class="fa-solid fa-bed"></i><span>King Size Bed</span></div>
                <div class="feature"><i class="fa-solid fa-user-group"></i><span>2 Adults, 1 Child</span></div>
                <div class="feature"><i class="fa-solid fa-vector-square"></i><span>450 sq. ft.</span></div>
                <div class="feature"><i class="fa-solid fa-wifi"></i><span>Free High-Speed WiFi</span></div>
                <div class="feature"><i class="fa-solid fa-mug-hot"></i><span>Complimentary Breakfast</span></div>
                <div class="feature"><i class="fa-solid fa-snowflake"></i><span>Air Conditioning</span></div>
                <div class="feature"><i class="fa-solid fa-tv"></i><span>Smart TV</span></div>
                <div class="feature"><i class="fa-solid fa-bath"></i><span>Private Bathroom</span></div>
                <div class="feature"><i class="fa-solid fa-champagne-glasses"></i><span>Mini Bar</span></div>
                <div class="feature"><i class="fa-solid fa-bell-concierge"></i><span>24/7 Room Service</span></div>
                <div class="feature"><i class="fa-solid fa-square-parking"></i><span>Free Parking</span></div>
                <div class="feature"><i class="fa-solid fa-city"></i><span>City View</span></div>
            </div>

            <div class="room1_book_btn">
                <a href="book_room.php?room_id=1">
                    <button>Book This Room</button>
                </a>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>