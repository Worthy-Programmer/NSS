<?php
require_once '../../../vendor/autoload.php';
require_once "./../access_restrict.php";

use Fahd\NSS\Event;

$event = new Event(0);


if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $event = new Event($_GET['id']);
  $event->getData();
  $event->getUsers();

  // var_dump($event->users[]);
}
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
  <link rel="stylesheet" href="../../styles/admin/events/detail.css" />

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
    <h3>DETAILS</h3>

    <ul>
      <li><label for="id">ID</label> <input type="text" id="id" value="<?= $event->id ?>" disabled /></li>
      <li><label for="credits">Name</label>
        <input type="text" id="credits" value="<?= $event->name ?? "" ?>" />
      </li>

      <li><label for="credits">From Date</label>
        <input type="datetime-local" id="credits" value="<?= $event->startDatetimeString ?? "" ?>" />
      </li>

      <li><label for="credits">To Date</label>
        <input type="datetime-local" id="credits" value="<?= $event->endDatetimeString ?? "" ?>" />
      </li>

      <li><label for="credits">Venue</label>
        <input type="name" id="credits" value="<?= $event->venue ?? ""  ?>" />
      </li>

    </ul>

  </section>
  <section class="jumbotron" id="select">
    <h3>ABOUT</h3>

    <textarea name="" id=""><?= $event->content ?? "" ?></textarea>
  </section>

  <section class="jumbotron" id="select">
    <h3>VOLUNTEERS</h3>

    <ul>
      <li><label for="id">Credits assigned</label> <input type="number" id="id" value="<?= $event->credits  ?? "" ?>" /> </li>
      <li><label for="id">Max Cap of Volunteers</label> <input type="number" id="id" value="<?= $event->max_vol ?? "" ?>" /></li>
      <li><label for="id">No of Volunteers</label> <input type="number" id="id" disabled value="<?= $event->userCount ?? "" ?>" /></li>

  </section>

  <section class="jumbotron" id="select">
    <h3>UPDATE CHANGES</h3>

    <p>Are you sure to save changes. Once it is saved, the previous data cannot be obtained.</p>

    <input type="submit" value="Save">
  </section>

  <?php if ($event->userCount ?? false): ?>
    <table id="credits_sheet">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Credits</th>
        </tr>
      </thead>

      <tbody>
        <?php for ($i = 0; $i < $event->userCount; $i++): ?>
          <?php $user = $event->users[$i] ?>
          <tr>
            <td><?= $user[0] ?></td>
            <td style="text-transform:capitalize"><?= $user[1] ?></td>
            <td><?= $user[2] ?></td>
          </tr>
        <?php endfor; ?>
      </tbody>
    </table>

  <?php endif; ?>
</div>

</html>