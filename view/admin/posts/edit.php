<?php
require_once '../../../vendor/autoload.php';
require_once "./../access_restrict.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../../static/logo.png" />

  <!-- CSS Styles -->
  <link rel="stylesheet" href="../../styles/init.css" />
  <link rel="stylesheet" href="../../styles/admin/index.css" />
  <link rel="stylesheet" href="../../styles/admin/credits.css" />




  <!-- Font Awesome -->
  <script
    src="https://kit.fontawesome.com/6db7b46a37.js"
    crossorigin="anonymous"></script>

  <title>Events | NSS IITM Admin Portal </title>
</head>

<body>


  <!-- Header -->
  <header>
    <div id="logo">
      <img src="../../static/logo.png" alt="NSS Logo" />
      <h2>IIT MADRAS</h2>
    </div>
    <i id="hamburger" class="fas fa-bars"></i>
    <nav>
      <a href="./">Dashboard</a>
      <a href="../credits.php">Credits</a>
      <a href="./" class="active">Events</a>
      <a href="../../logout.php">Logout</a>
    </nav>
  </header>

</body>


<div id="wrapper">

  <section class="jumbotron" id="select">
    <h3>SELECT</h3>

    <form action="">
      <ul>
        <li><label for="id">ID</label> <input type="text" id="id" /></li>
        <li><label for="credits">Name</label>
          <input type="text" id="credits" />
        </li>

        <li><label for="credits">From Date</label>
          <input type="date" id="credits" />
        </li>

        <li><label for="credits">To Date</label>
          <input type="date" id="credits" />
        </li>

        <li><label for="credits">From Time</label>
          <input type="time" id="credits" />
        </li>

        <li><label for="credits">To Time</label>
          <input type="time" id="credits" />
        </li>
        <li><label for="credits">Venue</label>
          <input type="name" id="credits" />
        </li>

      </ul>
      <input type="submit" value="Submit" />

    </form>
  </section>


  <section class="jumbotron" id="edit">
    <h3>TASKS</h3>
    <ul>
      <li><a href="">Details</a></label>
      <li><a href="">View Posts</a></li>
      <li><a href="">Participants</a></li>
      <li><a href="">Registration Form</a></li>


    </ul>
  </section>

  <table id="credits_sheet">
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Registered</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td>Lorem2</td>
        <td>Lorem2</td>
        <td>Lorem2</td>
        <td>Lorem2</td>
        <td>Lorem2</td>
      </tr>
      <tr>
        <td>Lorem2</td>
        <td>Lorem2</td>
        <td>Lorem2</td>
        <td>Lorem2</td>
        <td>Lorem2</td>
      </tr>
      <tr>
        <td>Lorem2</td>
        <td>Lorem2</td>
        <td>Lorem2</td>
        <td>Lorem2</td>
        <td>Lorem2</td>
      </tr>
    </tbody>
  </table>

</div>

</html>