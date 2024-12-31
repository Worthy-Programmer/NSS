<?php
require_once '../../../vendor/autoload.php';
require_once "./../access_restrict.php";

use Fahd\NSS\Events\Event;

$event = new Event(0);

$post_names = ['id', 'name', 'from_date', 'to_date', 'venue', 'credits', 'max_vol', 'content'];
$is_post_fields_present = array_reduce($post_names, fn($carry, $name) => $carry && isset($_POST[$name]), true);


// PUT EVENT
if ($is_post_fields_present) {
  $event->id = $_POST['id'];
  $event->name = $_POST['name'];
  $event->startDatetimeString = $_POST['from_date'];
  $event->endDatetimeString = $_POST['to_date'];
  $event->venue = $_POST['venue'];
  $event->credits = $_POST['credits'];
  $event->max_vol = $_POST['max_vol'];
  $event->content = $_POST['content'];


  // UPDATE 
  if ($event->id > 0)
    $event->update();
  else
    $event->insert();


  $event->getUsers();
} else if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  // GET EVENT
  $event = new Event($_GET['id']);
  $event->get();
  $event->getUsers();
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
  <link rel="stylesheet" href="../../styles/admin/utils/jumbotron.css" />
  <link rel="stylesheet" href="../../styles/admin/utils/table_records.css" />

  <link rel="stylesheet" href="../../styles/admin/events/view.css" />

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

  <form method="POST" action="" id="wrapper">
    <section class="jumbotron">
      <h3>DETAILS</h3>

      <input type="hidden" name="id" value="<?= $event->id ?>">
      <ul>
        <li><label for="id">ID</label> <input type="text" id="id" name="id" value="<?= $event->id ?>" disabled /></li>
        <li><label for="name">Name</label>
          <input required type="text" id="name" name="name" value="<?= $event->name ?? "" ?>" />
        </li>

        <li><label for="from_date">From Date</label>
          <input required type="datetime-local" id="from_date" name="from_date" value="<?= $event->startDatetimeString ?? "" ?>" />
        </li>

        <li><label for="to_date">To Date</label>
          <input required type="datetime-local" id="to_date" name="to_date" value="<?= $event->endDatetimeString ?? "" ?>" />
        </li>

        <li><label for="venue">Venue</label>
          <input required type="name" id="venue" name="venue" value="<?= $event->venue ?? ""  ?>" />
        </li>

      </ul>

    </section>
    <section class="jumbotron">
      <h3>ABOUT</h3>

      <textarea name="content" id="content"><?= $event->content ?? "" ?></textarea>
    </section>

    <section class="jumbotron">
      <h3>VOLUNTEERS</h3>

      <ul>
        <li><label for="id">Credits assigned</label> <input required="number" id="credits" name="credits" value="<?= $event->credits  ?? "" ?>" /> </li>
        <li><label for="id">Max Cap of Volunteers</label> <input required type="number" id="max_vol" name="max_vol" value="<?= $event->max_vol ?? "" ?>" /></li>
        <li><label for="id">No of Volunteers</label> <input required="number" disabled value="<?= $event->userCount ?? "" ?>" /></li>

    </section>

    <section class="jumbotron">
      <h3>UPDATE CHANGES</h3>

      <p>Are you sure to save changes. Once it is saved, the previous data cannot be obtained.</p>

      <input type="submit" value="Save">
    </section>

    <?php if ($event->userCount ?? false): ?>
      <table class="table_records">
        <thead>
          <tr>
            <th></th>
            <th>ID</th>
            <th>Name</th>
            <th>Credits</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($event->users as $user): ?>
            <tr>
              <td><input type="checkbox" name="" id=""></td>
              <td><?= $user[0] ?></td>
              <td style="text-transform:capitalize"><?= $user[1] ?></td>
              <td><?= $user[2] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>

    <?php endif; ?>
  </form>

</body>

</html>