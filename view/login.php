<?php
  require '../vendor/autoload.php';
  use Fahd\NSS\Auth\SessionHandler;

  if (SessionHandler::isLoggedIn()) {
    header("Location: ./dashboard.php");
    exit;
  }
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
  <link rel="stylesheet" href="styles/login.css" />

  <!-- Font Awesome -->
  <script
    src="https://kit.fontawesome.com/6db7b46a37.js"
    crossorigin="anonymous"></script>

  <title>Login | NSS IITM</title>
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
      <a href="./">Home</a><a href="./login.php" class="active">Login</a>
    </nav>
  </header>



  <section id="login_section">
    <form action="../api/login.php" method="post" >
      <fieldset>
        <legend>Login</legend>
        <input type="text" name="id" placeholder="Roll No"  required autofocus/>
        <input type="password" name="pwd" placeholder="Password" required />

        <p id="status"></p>
        <input type="submit" value="Submit">
      </fieldset>
    </form>

    <div>
      <img src="./static/login.svg" alt="Login illustration">
    </div>
  </section>



  <!-- Scripts -->
  <script src="./scripts/header.js"></script>
  <script src="./scripts/login.js"></script>
</body>

</html>