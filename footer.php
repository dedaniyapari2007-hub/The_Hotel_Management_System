<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
</head>
<body>
    <div class="footer">
  <div id="box1">
      <div class="contact">
            <h2>Contact Us</h2>
            <div id="num">+91 9087643255</div>
            <div id="mail">@gmail.com</div>
      </div>
          <div class="visit-us">
            <h2>Visit Us</h2>
            <div id="add1"> Hotel Platinum Palace</div>
             <div id="add2">Indira Circle 150ft RingRoad,</div>
              <div id="add3">Rajkot.</div>
          </div>
          <div class="icons">
            <i class="fa-brands fa-facebook" style="color: rgb(116, 192, 252);"></i>
            <div id="face_book">Platinum_Palace_Rajkot</div>
          </div>
          <div class="icon_2">
            <i class="fa-brands fa-instagram" style="color: rgb(116, 192, 252);"></i>
            <div id="instagram">Platinum_Palace_Rajkot</div>
          </div>
      </div>
      <div style="text-align: center; margin-top: 20px;">
          <a href="admin/admin_login.php" style="color: #ccc; text-decoration: none; font-size: 12px; opacity: 0.5;">Admin Panel</a>
      </div>
  </div> 

  <!-- Scroll to Top Button -->
  <button id="scrollToTopBtn" style="display:none; position:fixed; bottom:20px; right:20px; z-index:99; border:none; outline:none; background-color:#D4A373; color:white; cursor:pointer; padding:15px; border-radius:50%; font-size:18px; width:50px; height:50px; box-shadow: 0 4px 8px rgba(0,0,0,0.2); transition: background-color 0.3s ease;">
    <i class="fa-solid fa-arrow-up"></i>
  </button>

  <script>
    // Scroll to Top Logic
    const scrollToTopBtn = document.getElementById("scrollToTopBtn");
    window.onscroll = function() {
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            scrollToTopBtn.style.display = "block";
        } else {
            scrollToTopBtn.style.display = "none";
        }
    };
    scrollToTopBtn.onclick = function() {
        window.scrollTo({top: 0, behavior: 'smooth'});
    };

    // Animation on Scroll Logic
    document.addEventListener("DOMContentLoaded", function() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target); // Optional: only animate once
                }
            });
        }, { threshold: 0.1 });

        const animElements = document.querySelectorAll('.animate-on-scroll');
        animElements.forEach(el => observer.observe(el));
    });
  </script>
</body>
</html>