<?php

use NSS\Events\EventRecords;
use UI\Head;
use UI\Navbar;
use UI\SelectFilter;
use UI\TableRecords;
use NSS\Utils\Helper;

require_once '../../../vendor/autoload.php';
require_once "../access_restrict.php";

$events = [];

$post_names = ['mass_edit_select', 'credits'];
$is_post_fields_present = Helper::isAllKeysInArray($post_names, $_POST);

if ($is_post_fields_present) {
  $eventList = new EventRecords(EventRecords::filterFields());

  if ($eventList->ids && in_array($_POST['mass_edit_select'], ["add", "set"])) {
    $res = call_user_func([&$eventList, $_POST['mass_edit_select'] . 'IntField'], "credits", (int) $_POST['credits']);
  }

  $events = $eventList->ids;
}

$get_names = ['name', 'id', 'id_select', 'name_select'];

$is_get_fields_present = Helper::isAllKeysInArray($get_names, $_GET);
$name_filter_selected = $id_filter_selected = '';
if ($is_get_fields_present) {
  $userList = new EventRecords;
  $userList->colValue = ["id" => $_GET['id'], "name" => $_GET['name']];
  $userList->colSelect = ["id" => $_GET['id_select'], "name" => $_GET['name_select']];
  $events = $userList->get();
  $name_filter_selected = $_GET['name_select'];
  $id_filter_selected = $_GET['id_select'];
}

?>

<!DOCTYPE html>
<html lang="en">

<?php (new Head('Event Selector | Admin', ['init.css', 'admin/index.css', 'admin/events/index.css']))->render(); ?>

<body>

  <?php (new Navbar([
    "Dashboard" => "/view/admin/",
    "Users" => "/view/admin/users/",
    "Events" => "/view/admin/events/",
    "Logout" => "/view/auth/logout.php"
  ], "Events"))->render(); ?>


  <div id="wrapper">

    <section class="jumbotron" id="select">
      <h3>SELECT EVENTS</h3>

      <form action="" method="GET">
        <ul>
          <li>
            <label for="id">ID</label>
            <?php (new SelectFilter('id_select', 'id_select', SelectFilter::NUMBER_FILTER_OPTIONS, $id_filter_selected))->render(); ?>

            <input type="text" id="id" name="id" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>" />

          </li>

          <li>
            <label for="name">Name</label>
            <?php (new SelectFilter('name_select', 'name_select', SelectFilter::STRING_FILTER_OPTIONS, $name_filter_selected))->render(); ?>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($_GET['name'] ?? '') ?>" />

          </li>

          <br>
          <input type="submit" value="Submit" />

      </form>
    </section>



    <form action="" method="POST" class="jumbotron" id="edit">
      <h3>MASS EDIT</h3>

      <ul>
        <li>
          <select name="mass_edit_select" id="mass_edit_select">
            <option value="add">Add Credits by</option>
            <option value="set">Set Credits to</option>
          </select>

          <input type="number" name="credits" required />
        </li>

      </ul>

      <div>
        <button type="button" id="select_all_btn">Select All</button>
        <button type="button" id="deselect_all_btn">Deselect All</button>

        <input type="submit" value="Edit" disabled />


        <button type="submit" id="delete_btn" disabled formnovalidate form>Delete</button>
      </div>


    </form>


    <?php if ($events) (new TableRecords(
      'event',
      [
        '',
        'ID',
        'Name',
        'Start Date Time',
        'End Date Time',
        'Credits'
      ],

      $events,

      fn($event) => [
        [TableRecords::CHECKBOX_WITH_FORM, ["u_" . $event['id'], "u_" . $event['id'], 'edit']],
        strtoupper($event['id']),
        [TableRecords::LINK, ['./view.php?id=' . $event['id'], ucwords($event['name'])]],
        $event['start_datetime'],
        $event['end_datetime'],
        $event['credits']
      ]
    ))->render(); ?>

  </div>
  </div>

  <script type="module" src="/view/scripts/pages/records.js"></script>


</html>