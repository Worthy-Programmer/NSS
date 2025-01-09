<?php
require_once '../../../vendor/autoload.php';
require_once "./../access_restrict.php";

use NSS\Events\Event;
use NSS\Utils\Helper;
use UI\Head;
use UI\Navbar;
use UI\TableRecords;

$event = new Event(0);

$is_event_create = true;

$post_names = ['id', 'name', 'from_date', 'to_date', 'venue', 'credits', 'max_vol', 'content'];
$is_post_fields_present = Helper::isAllKeysInArray($post_names, $_POST);


// PUT EVENT
if ($is_post_fields_present) {
  $is_event_create = false;

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
    $event->create();


  $event->getUsers();
} else if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  // GET EVENT
  $event = new Event($_GET['id']);

  if (isset($_POST['add_user'])) {
    $user_ids = explode(',', $_POST['add_user']);
    $event->addUsers($user_ids);
  }

  $event->read();
  $event->getUsers();
  $is_event_create = false;
}


?>

<!DOCTYPE html>
<html lang="en">

<?php (new Head("Event View | Admin", ['init.css', 'admin/index.css', 'utils/jumbotron.css', 'utils/table_records.css', 'admin/events/view.css']))->render() ?>

<body>

  <?php (new Navbar([
    "Dashboard" => "/view/admin/",
    "Users" => "/view/admin/users/",
    "Events" => "/view/admin/events/",
    "Logout" => "/view/auth/logout.php"
  ], "Events"))->render(); ?>



  <form method="POST" action="<?= $event->id ? '?id=' . $event->id : '' ?>" id="wrapper">
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


  </form>


  <?php if (!$is_event_create): ?>
    <form action="?id=<?= $event->id ?>" id="user" class="wrapper" method="POST">

      <input type="hidden" name="event_id" value="<?= $event->id ?>">
      <div class="jumbotron">
        <h3>JOINED VOLUNTEERS</h3>
        <div id="edit_tools">

          <div>
            <input type="text" id="add_input" placeholder="Enrol Volunteers" name="add_user" required>
            <button type="submit">Enrol</button>
          </div>
        </div>

        <button type="button" class="delete_btn" disabled>Remove Volunteers</button>
        <button type="button" id="mark_attendance" disabled> <i class="fas fa-check"></i> Attend</button>

        <button type="button" id="unmark_attendance" class="delete_btn" disabled> <i class="fas fa-times"></i> Attend</button>

        <!-- <button type="button" id=/></button> -->
      </div>

      <?php
      if ($event->userCount ?? false) (new TableRecords(
        'enrolled_users',
        ['', 'ID', 'Name', 'Attendance'],
        $event->users,
        fn($user) => [
          [TableRecords::CHECKBOX, ['u_' . $user[0], 'u_' . $user[0]]],
          strtoupper($user[0]),
          ucwords($user[1]),
          ["<i class='fas fa-%s' > </i>",  [$user[2] ? 'check' : 'times']]
        ]
      ))->render();

      ?>

    </form>
  <?php endif ?>
  <script type="module" src="./view.js"></script>

</body>

</html>