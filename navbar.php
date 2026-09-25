<?php if (session_status() === PHP_SESSION_NONE) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platinum Palace</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Lilita+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<!-- Professional Navbar -->
<nav class="navbar">
    <div class="nav-container">
        <!-- Logo Area -->
        <a href="index.php" class="logo-area">
            <span class="logo-text">Platinum</span>
            <img src="assets/images/main_logo.webp" alt="Logo" class="logo-img">
            <span class="logo-text">Palace</span>
        </a>

        <!-- Desktop Links -->
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="the_hotel.php">The Hotel</a></li>
            <li><a href="our_rooms.php">Our Rooms</a></li>
            <li><a href="food_drink.php">Food & Drinks</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>

        <!-- Action Area -->
        <div class="nav-actions">
            <!-- Rate Us Star -->
            <button class="rate-us-btn" id="openReviewModal" title="Rate Us!">
                <i class="fa-regular fa-star"></i>
            </button>

            <!-- User Account Dropdown -->
            <div class="user-menu-container">
                <i class="fa-solid fa-circle-user" id="userIcon"></i>
                <div class="user-dropdown">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="user-greeting">Hi, <?php echo htmlspecialchars($_SESSION['name']); ?></div>
                        <a href="booking_1.php">Dashboard</a>
                        <a href="booking.php">Explore Rooms</a>
                        <a href="booking_1.php">My Bookings</a>
                        <div class="dropdown-divider"></div>
                        <a href="logout.php">Log Out</a>
                    <?php else: ?>
                        <div class="user-greeting">Welcome!</div>
                        <a href="login.php">Log In</a>
                        <a href="register.php">Sign Up</a>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Book Now Button -->
            <a href="booking.php" class="btn-booking">Bookings</a>
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="menu-toggle" id="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</nav>

<!-- Review Modal -->
<div id="reviewModal" class="review-modal-overlay">
    <div class="review-modal-content">
        <span class="close-modal" id="closeReviewModal">&times;</span>
        <h2>Leave a Review</h2>
        <p>We'd love to hear about your experience at Platinum Palace!</p>
        
        <form action="submit_review.php" method="POST">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="reviewer_name" required 
                       value="<?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : ''; ?>" 
                       <?php echo isset($_SESSION['name']) ? 'readonly' : ''; ?> >
            </div>
            
            <div class="form-group">
                <label>Title of your review</label>
                <input type="text" name="title" placeholder="e.g. Dreamy Environment" required>
            </div>
            
            <div class="form-group">
                <label>Your Review</label>
                <textarea name="review_text" rows="4" placeholder="Tell us what you loved..." required></textarea>
            </div>
            
            <div class="form-group rating-group">
                <label>Rating</label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="5 stars"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star"><i class="fa-solid fa-star"></i></label>
                </div>
            </div>
            
            <button type="submit" name="submit_review" class="btn-submit-review">Submit Review</button>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Mobile Menu Toggle
    const menuToggle = document.getElementById('menu-toggle');
    const navLinks = document.querySelector('.nav-links');
    if(menuToggle && navLinks) {
        menuToggle.addEventListener('click', function () {
            navLinks.classList.toggle('active');
            menuToggle.classList.toggle('active');
        });
    }

    // Modal Logic
    const modal = document.getElementById("reviewModal");
    const openBtn = document.getElementById("openReviewModal");
    const closeBtn = document.getElementById("closeReviewModal");

    if(openBtn && modal && closeBtn) {
        openBtn.addEventListener("click", function() {
            modal.style.display = "flex";
            // small timeout to allow display:flex to apply before adding opacity for transition
            setTimeout(() => {
                modal.classList.add('show');
            }, 10);
        });

        closeBtn.addEventListener("click", function() {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = "none";
            }, 300); // match CSS transition duration
        });

        // Close on outside click
        window.addEventListener("click", function(event) {
            if (event.target == modal) {
                modal.classList.remove('show');
                setTimeout(() => {
                    modal.style.display = "none";
                }, 300);
            }
        });
    }
});
</script>