<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Rooms</title>
<link rel="stylesheet" href="our_rooms.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php include 'navbar.php';?>
    <div class="our_rooms_main_body_1">
        <p>Our Rooms</p>
        <h1>Spend The Night In The Heart Of The Platinum Palace</h1>
        <div id="subtitle1">"All our rooms have one thing in common – they are designed to ensure that your stay with </div>
        <div id="subtitle2"> as relaxing and comfortable as possible."</div>
        <div class="btn-bmrt"><a href="booking.php"><button>Book Your Room Today</button></a></div>
    </div>
    <?php include'rooms.php';?>
<div class="features_section">
  <div class="features_header">
    <h1>Our Premium Features</h1>
    <p>Everything you need for a perfect stay</p>
  </div>
  <div class="features_grid">
    <div class="feature_card">
      <i class="fa-solid fa-bell-concierge"></i>
      <h3>24/7 Room Service</h3>
      <p>Enjoy delicious meals in the comfort of your room at any time.</p>
    </div>
    <div class="feature_card">
      <i class="fa-solid fa-wifi"></i>
      <h3>High-Speed Wi-Fi</h3>
      <p>Stay connected with our complimentary high-speed internet.</p>
    </div>
    <div class="feature_card">
      <i class="fa-solid fa-spa"></i>
      <h3>Spa & Wellness</h3>
      <p>Relax and rejuvenate in our state-of-the-art spa facilities.</p>
    </div>
    <div class="feature_card">
      <i class="fa-solid fa-square-parking"></i>
      <h3>Secured Parking</h3>
      <p>Safe and convenient parking available for all our guests.</p>
    </div>
  </div>
</div>
<div class="main_body_5">
  <div class="head_main_body_5">
    <div id="sen1"><h1>Spend The Night</h1></div>
    <div id="sen2"><h1>In The Heart Of Platinum Palace</h1></div>
    <div id="sen3"><h4>We are here to help you.</h4></div>
  </div>

  <div class="two_buttons">
    <div class="my_button_1"><a href="booking.php"><button>Book Your Room</button></a></div>
    <div class="my_button_2"><a href="contact.php"><button>Ask Us Anything</button></a></div>
  </div>
</div>
<?php include 'footer.php'?>
</body>
</html>