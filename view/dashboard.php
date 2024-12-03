<?php

use Fahd\NSS\Auth\SessionHandler;
use Fahd\NSS\Users\User;

require '../vendor/autoload.php';
if (!SessionHandler::isLoggedIn()) header("Location: ./login.php");

$session = new SessionHandler();
$user = new User($session->username);
$user->getDetails();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="static/logo.png" />


  <!-- CSS Styles -->
  <link rel="stylesheet" href="styles/init.css" />
  <link rel="stylesheet" href="styles/dashboard.css" />

  <!-- Font Awesome -->
  <script
    src="https://kit.fontawesome.com/6db7b46a37.js"
    crossorigin="anonymous"></script>

  <title>NSS IITM</title>
</head>

<body>


  <!-- Header -->
  <header>
    <div id="logo">
      <img src="./static/logo.png" alt="NSS Logo" />
      <h2>IIT MADRAS</h2>
    </div>
    <i id="hamburger" class="fas fa-bars"></i>
    <nav>
      <a href="./">Home</a><a href="./login.php" class="active">Dashboard</a>
      <a href="./logout.php">Logout</a>
    </nav>
  </header>


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