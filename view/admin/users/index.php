<?php

header("Access-Control-Allow-Methods: GET,POST,DELETE");

use NSS\Users\UserRecords;
use NSS\Utils\Helper;
use UI\Head;
use UI\Navbar;
use UI\SelectFilter;
use UI\TableRecords;

require_once '../../../vendor/autoload.php';
require_once "../access_restrict.php";

$users = [];
$credits_filter_selected = '';
$id_filter_selected = '';

$post_names = ['mass_edit_select', 'credits'];
$is_post_fields_present = Helper::isAllKeysInArray($post_names, $_POST);

if ($is_post_fields_present) {
  $userList = new UserRecords(UserRecords::filterFields());

  if ($userList->ids && in_array($_POST['mass_edit_select'], ["add", "set"])) {
    $res = call_user_func([&$userList, $_POST['mass_edit_select'] . 'IntField'], "credits", (int) $_POST['credits']);
  }
}

$get_names = ['credits', 'id', 'id_select', 'credits_select'];
$is_get_fields_present  = Helper::isAllKeysInArray($get_names, $_GET);

if ($is_get_fields_present) {
  $userList = new UserRecords;
  $userList->colValue = ["id" => $_GET['id'], "credits" => $_GET['credits']];
  $userList->colSelect = ["id" => $_GET['id_select'], "credits" => $_GET['credits_select']];
  $users = $userList->get();
  $credits_filter_selected = $_GET['credits_select'];
  $id_filter_selected = $_GET['id_select'];
}

?>

<!DOCTYPE html>
<html lang="en">

<?php (new Head("Users", ['init.css', 'admin/index.css', 'admin/users/index.css']))->render(); ?>

<body>

  <?php (new Navbar([
    "Dashboard" => "/view/admin/",
    "Users" => "/view/admin/users/",
    "Events" => "/view/admin/events/",
    "Logout" => "/view/auth/logout.php"
  ], "Users"))->render(); ?>





  <div id="wrapper">

    <section class="jumbotron" id="select">
      <h3>SELECT USERS</h3>

      <form action="" method="GET">
        <ul>
          <li>
            <label for="id">ID</label>
            <?php (new SelectFilter('id_select', 'id_select', SelectFilter::STRING_FILTER_OPTIONS, $id_filter_selected))->render(); ?>

            <input type="text" id="id" name="id" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>" />

          </li>


          <li>
            <label for="credits">Credits</label>
            <?php (new SelectFilter('credits_select', 'credits_select', SelectFilter::NUMBER_FILTER_OPTIONS, $credits_filter_selected))->render(); ?>

            <input type="number" name="credits" id="credits" value="<?= htmlspecialchars($_GET['credits'] ?? '') ?>" />
          </li>
        </ul>
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
            <!-- <option value="delete">Delete Record</option> -->
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

    <?php if ($users) (new TableRecords(
      'user',
      [
        '',
        'ID',
        'Name',
        'Credits'
      ],
      $users,
      fn($user) => [
        [TableRecords::CHECKBOX_WITH_FORM, ["u_" . $user['id'], "u_" . $user['id'], "edit"]],
        strtoupper($user['id']),
        [TableRecords::LINK, ['./edit.php?id=' . $user['id'], ucwords($user['name'])]],
        $user['credits']
      ]
    ))->render(); ?>
  </div>

  <script type="module" src="/view/scripts/pages/records.js"></script>

</body>

</html>