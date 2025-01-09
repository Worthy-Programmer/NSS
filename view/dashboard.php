<?php

use NSS\Auth\SessionHandler;
use NSS\Users\User;
use UI\Head;
use UI\Navbar;

require '../vendor/autoload.php';
if (!SessionHandler::isLoggedIn()) header("Location: ./auth/login.php");

$admin_view = false;

$session = new SessionHandler();
$user = new User($session->username);
$user->read();

if(!$user->isVolunteer() & isset($_GET['id'])) {
  $user = new User($_GET['id']);
  $user->read(); 
  $admin_view = true;
}

$nav_items = [
  "Home" => "/",
  "Dashboard" => "/view/dashboard.php",
  "Logout" => "/view/auth/logout.php"
];

if (!$user->isVolunteer()) $nav_items["Admin"] = "/view/admin/";

?>

<!DOCTYPE html>
<html lang="en">

<?php (new Head($user->name, ['init.css', 'dashboard.css']))->render(); ?>

<body>


  <!-- Header -->
   <?php  (new Navbar($nav_items, "Dashboard"))->render(); 
   ?>

  <section id="profile">

    <img src="../api/pfp.php" alt="Profile picture" id="pfp">

    <div>
      <h2><?= $user->name ?></h2>
      <p>Credits gained: <?= $user->credits ?></p>

      <form id="pfp_form" action="" method="post" enctype="multipart/form-data">
        <label for="pfpToUpload">Profile Picture: </label>
        <input type="file" name="pfpToUpload" id="pfpToUpload" required>
        <input type="submit" value="Upload Image" name="submit">
        <p id="pfp_status"></p>
      </form>
    </div>
  </section>


  <!-- Scripts -->
  <script src="./scripts/header.js"></script>
  <script src="./scripts/pfp.js"></script>

</body>

</html>