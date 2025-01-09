<?php
require '../../vendor/autoload.php';

use NSS\Auth\SessionHandler;
use UI\Head;
use UI\Navbar;

if (SessionHandler::isLoggedIn()) {
  header("Location: ../dashboard.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<?php (new Head('Login', ['init.css', 'login.css']))->render(); ?>

<body>

  <?php
  (new Navbar([
    "Home" => "/",
    "Login" => "/view/auth/login.php"
  ], "Login"))->render();
  ?>



  <section id="login_section">
    <form action="" method="post">
      <fieldset>
        <legend>Login</legend>
        <input type="text" name="id" placeholder="Roll No" required autofocus />
        <input type="password" name="pwd" placeholder="Password" required />

        <p id="status"></p>
        <input type="submit" value="Submit">
      </fieldset>
    </form>

    <div>
      <img src="/view/static/login.svg" alt="Login illustration">
    </div>
  </section>



  <!-- Scripts -->
  <script src="/view/scripts/components/header.js"></script>
  <script src="/view/scripts/pages/login.js"></script>
</body>

</html>