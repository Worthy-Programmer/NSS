<!DOCTYPE html>
<html lang="en">

<?php
require_once '../vendor/autoload.php';

use UI\Head;
use UI\Navbar;

(new Head('Home', ['init.css', 'slider.css', 'index.css']))->render();

?>

<body>


  <?php
  (new Navbar([
    "Home" => "/",
    "Login" => "/view/auth/login.php"
  ], "Home"))->render();
  ?>

  <!-- Slider -->
  <section id="slider">
    <div class="carousel" id="carousel_homepage">
      <div class="carousel-items">
        <div class="carousel-item"><img src="./static/slider2.jpg" alt=""></div>
        <div class="carousel-item"><img src="./static/slider1.jpg" alt=""></div>
        <div class="carousel-item"><img src="./static/slider3.jpg" alt=""></div>
      </div>
      <button class="carousel-control prev">❮</button>
      <button class="carousel-control next">❯</button>
    </div>

  </section>

  <!-- About us -->
  <section class="details mt-less">

    <img src="./static/love.svg" alt="Love">
    <div>
      <h2>Mission</h2>
      <p>The National Service Scheme (NSS) at IIT Madras, started over four decades ago, is a student-run organization focused on benefiting society. It aims to inspire the youth to become responsible citizens. NSS fosters a passion for social service. Its mission is to make a positive impact through various initiatives.</p>
    </div>
  </section>

  <section class="details reverse">

    <div>
      <h2>Impact</h2>
      <p>NSS IIT Madras engages over 300 students annually, driving diverse projects like Braille magazines, teaching, and tech interventions. Collaborating with NGOs, they address social issues such as education, environment, and animal care.</p>

    </div>
    <img src="./static/impact.svg" alt="Impact">

  </section>

  <section class="details ">
    <img src="./static/mailbox.svg" alt="Contact Address">

    <div>
      <h2>Contact Details</h2>
      <address>

        <section>
          <b>Address: </b>
          <div>NSS Office, 1st Cross Road, Near IITM Post Office, IIT Madras, Chennai, TN. </div> <br>
        </section>

        <section>
          <b>Phone Numbers</b>
          <div>Anjali Kalunke:
            <a href="tel:+919156233178">+919156233178 </a>
          </div>
          <div>Ankit Aryan:
            <a href="tel:+917488701168">+917488701168 </a>
          </div>
          <div>Muthu Kumar:
            <a href="tel:+919952615494">+919952615494 </a>
          </div>
          E-mail:
          <a href="mailto:nss@iitm.ac.in">nss@iitm.ac.in</a>
        </section>


      </address>

    </div>
  </section>


  <!-- Footer -->
  <footer>
    <div>NSS IITM</div>


    <div id="footer_links">
      <a href="" class="fab fa-instagram"></a>
      <a href="" class="fab fa-facebook"></a>
      <a class="fab fa-twitter"></a>
      <a class="fab fa-google-plus-g"></a>
    </div>

    <div id="footer_author">By Fahd B</div>


  </footer>


  <!-- Scripts -->
  <script src="./scripts/header.js"></script>
  <script src="./scripts/Carousel.js"></script>
  <script>
    new Carousel("carousel_homepage")
  </script>

</body>

</html>