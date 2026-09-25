<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar Example</title>
  <link rel="stylesheet" href="style.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
      <?php include 'navbar.php'; ?>
<div class="background_body">
      <section class="hero">
        <div class="hero-content">
            <h1>The Heart Of The Platinum Palace</h1>
        </div>
      </section>
      <div class="btns">
        <a href="booking.php" class="btn-link"><button class="bn">Book Now</button></a>
        <a href="contact.php" class="btn-link"><button class="cu">Contact Us</button></a>
      </div>
    
</div>

<div class="main_body animate-on-scroll">
  <div class="main_body_part_1"><h1>Welcome To Platinum Palace</h1></div>
  <div class="main_body_part_2"><h3>A Unique Hotel Experience In Platinum</h3></div>


<div class="main_div">
  <div class="part_1_div animate-on-scroll">
    <div id="heading1"><h2>Unique & Personal</h2></div>
    <div id="containt1"><p>Our wish is to offer you a unique and more personal hotel experience. We want you to feel at home when you’re staying at our hotel – that means we go the extra mile to ensure your needs and wants are fulfilled. If you need anything, we stand ready to assist.
    </p>
    </div>
  </div>
<div class="part_1_div animate-on-scroll">
    <div id="heading1"><h2>The Extra Smile</h2></div>
    <div id="containt1"><p>Our focus is on delivering that little extra that makes your stay with us memorable. Our guests can enjoy free admission to the Vikinghallen fitness center as well as excellent discounts on selected restaurants and bars in Bergen. Inquire in the lobby for more information.</p>
    </div>
</div>

<div class="part_1_div animate-on-scroll">
    <div id="heading1"><h2>Transport and parking</h2></div>
    <div id="containt1"><p>The airport express coach – and most other buses in Bergen – have stops by Bryggen, no more than a couple of minutes walk from the hotel. Just around the corner you will also find Rosenkrants parking garage. If you prefer vertical travel to horizontal, there’s always the Fløyen Funicular just down the street.</p>
    </div>
</div>
</div>
<div class="main_body_2 animate-on-scroll">
  <div class="gallery-grid">
    <img src="assets/images/body_1.jpg" alt="Hotel view 1">
    <img src="assets/images/body_3.jpg" alt="Hotel view 2">
    <img src="assets/images/Boutique_Hotel4.webp" alt="Hotel view 3">
    <img src="assets/images/body_4.jpg" alt="Hotel view 4">
    <img src="assets/images/body_6.jpg" alt="Hotel view 5">
    <img src="assets/images/body_8.jpg" alt="Hotel view 6">
    <img src="assets/images/body_5.jpg" alt="Hotel view 7">
    <img src="assets/images/body_7.jpg" alt="Hotel view 8">
    <img src="assets/images/body_2.jpg" alt="Hotel view 9">
  </div>
</div>
<div class="main_body_3 animate-on-scroll">
    <div id="heading_of_body_part_3"><h1>What Our Guests Say About Us:</h1></div>
    <div class="square_body_3">
        <div class="heading_review"><i><h2>Fab Place</h2></i></div>
        <img src="assets/images/star.png" class="review-star-img" alt="5 Stars">
          <div class="heading_containt"><p>My first stay at Bergen Harbour Hotel was just a great     visit, a really cozy nice hotel close to the city harbour in the
          center of town. Deliceous breakfast and a cozy bar. I'll be highly recommend this boutique hotel, i'll be back!</p>
        </div>
        <div class="review_name" style="text-align: center;">- John Barklian</div>
</div>
</div>

<div class="main_body_4 animate-on-scroll">
  <div class="part_1_main_body_4">
    <div class="part_1_main_body_4_1">
      <div class="he1"><i class="fa-solid fa-location-dot"></i><h1>Top Location</h1></div>
        <div class="containt"><p>We are located right between Fløien, Bryggen and the Fish Market, and among hundreds of restaurants, cafés, shops, bars and clubs.</p>
        </div>
    </div>
     <div class="part_1_main_body_4_2" >
      <div class="he1"><i class="fa-solid fa-heart"></i><h1>A Charming Hotel</h1></div>
        <div class="containt"><p>We do our best for you to enjoy your stay at our charming boutique hotel.</p>
        </div>
     </div> 
  </div>
  <div class="part_2_main_body_4">
      <div class="part_2_main_body_4_1">
        <div class="he1"><i class="fa-solid fa-person-running"></i><h1>Activities & Attractions</h1></div>
          <div class="containt"><p>There are so many fun and interesting things you can do in Bergen! We help you on your way and can give you discounts on selected attractions and places to eat.</p>
          </div>
      </div>
      <div class="part_2_main_body_4_2">
        <div class="he1"><i class="fa-solid fa-star"></i><h1>Very Pleased Guests</h1></div>
          <div class="containt"><p>Not many hotels have so many happy guests as ours.</p>
          </div>
      </div>
  </div>
</div>

<div class="main_body_5 animate-on-scroll">
  <div class="head_main_body_5">
    <div id="sen1"><h1>Spend The Night</h1></div>
    <div id="sen2"><h1>In The Heart Of Platinum Palace</h1></div>
    <div id="sen3"><h4>We are hear to help you.</h4></div>
  </div>

  <div class="two_buttons">
    <a href="booking.php"><div class="my_button_1"><button>Book Your Room</button></div></a>
    <a href="contact.php"><div class="my_button_2"><button>Ask Us Anything</button></div></a>
  </div>
</div>

  <?php include 'footer.php';?>
  <script>
    document.getElementById('menu-toggle').addEventListener('click', function () {
      document.querySelector('.nav-links').classList.toggle('active');
    });
  </script>
  <script>
    <?php
      include 'connection.php';
      $reviews_query = "SELECT title, review_text, reviewer_name FROM reviews ORDER BY created_at DESC LIMIT 10";
      $reviews_result = $conn->query($reviews_query);
      $reviews_array = [];
      if ($reviews_result && $reviews_result->num_rows > 0) {
          while($row = $reviews_result->fetch_assoc()) {
              $reviews_array[] = [
                  'title' => htmlspecialchars($row['title']),
                  'text'  => htmlspecialchars($row['review_text']),
                  'name'  => "- " . htmlspecialchars($row['reviewer_name'])
              ];
          }
      } else {
          // Fallback if no reviews
          $reviews_array[] = [
              'title' => "Dreamy Environment",
              'text'  => "I am always wanted this type of stay in reganable price i am wondering that i found a best environment for me and my family where food is also too good !...",
              'name'  => "- John Barklian"
          ];
      }
    ?>
    const reviews = <?php echo json_encode($reviews_array); ?>;

let currentIndex = 0;

function updateReview() {
  const container = document.querySelector('.square_body_3');
  container.classList.add('fade-out');

  setTimeout(() => {
    container.querySelector('.heading_review h2').textContent = reviews[currentIndex].title;
    container.querySelector('.heading_containt p').textContent = reviews[currentIndex].text;
    container.querySelector('.review_name').textContent = reviews[currentIndex].name;

    currentIndex = (currentIndex + 1) % reviews.length;
    container.classList.remove('fade-out');
  }, 500); // matches the CSS transition duration
}

setInterval(updateReview, 3000);
  </script>
  
</body>
</html>