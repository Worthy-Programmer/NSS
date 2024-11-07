<?php
require_once '../../vendor/autoload.php';
require_once "./access_restrict.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../static/logo.png" />

  <!-- CSS Styles -->
  <link rel="stylesheet" href="../styles/init.css" />
  <link rel="stylesheet" href="../styles/admin/index.css" />
  <!-- <link rel="stylesheet" href="../styles/admin/credis.css" /> -->


  <!-- Font Awesome -->
  <script
    src="https://kit.fontawesome.com/6db7b46a37.js"
    crossorigin="anonymous"></script>

  <title>Dashboard | NSS IITM Admin Portal </title>
</head>

<body>


  <!-- Header -->
  <header>
    <div id="logo">
      <img src="../static/logo.png" alt="NSS Logo" />
      <h2>IIT MADRAS </h2>
    </div>
    <i id="hamburger" class="fas fa-bars"></i>
    <nav>
      <a href="./" class="active">Dashboard</a>
      <a href="./credits.php">Credits</a>
      <a href="./events.php" s>Events</a>
      <a href="../logout.php">Logout</a>
    </nav>
  </header>


</body>


<div id="wrapper">

  <section class="jumbotron">
    <h3>Credits</h3>
    <ul>
      <li><a href="">Sheet</a></li>
      <li><a href="">Edit Credits</a></li>
    </ul>
  </section>


  <section class="jumbotron">
    <h3>Events</h3>
    <ul>
      <li><a href="">Add Event</a></li>
      <li><a href="">Event List</a></li>
      <li><a href="">Blog post</a></li>
    </ul>
  </section>
  <!-- 
  <section class="jumbotron">
    <h3>Users</h3>
    <ul>
      <li></li>
    </ul>
  </section> -->
</div>

</html>