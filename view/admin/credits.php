<?php

use Fahd\NSS\Users\UserRecords;

require_once '../../vendor/autoload.php';
require_once "./access_restrict.php";

$users = [];

$post_names = ['mass_edit_select', 'credits'];
$is_post_fields_present = array_reduce($post_names, fn($carry, $name) => $carry && isset($_POST[$name]), true);

if ($is_post_fields_present) {
  $userList = new UserRecords(UserRecords::filterFields());

  if ($userList->ids && in_array($_POST['mass_edit_select'], ["add", "set"])) {
    $res = call_user_func([&$userList, $_POST['mass_edit_select'] . 'Credits'], (int) $_POST['credits']);
  }
}

$get_names = ['credits', 'id', 'id_select', 'credits_select'];
$is_get_fields_present  = array_reduce($get_names, fn($carry, $name) => $carry && isset($_GET[$name]), true);

if ($is_get_fields_present) {
  $userList = new UserRecords;
  $userList->colValue = ["id" => $_GET['id'], "credits" => $_GET['credits']];
  $userList->colSelect = ["id" => $_GET['id_select'], "credits" => $_GET['credits_select']];
  $users = $userList->getRecords();
  $number_filter_selected = $_GET['credits_select'];
  $string_filter_selected = $_GET['id_select'];
}

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
  <link rel="stylesheet" href="../styles/admin/credits.css" />




  <!-- Font Awesome -->
  <script
    src="https://kit.fontawesome.com/6db7b46a37.js"
    crossorigin="anonymous"></script>

  <title>Credits | NSS IITM Admin Portal </title>
</head>

<body>


  <!-- Header -->
  <header>
    <div id="logo">
      <img src="../static/logo.png" alt="NSS Logo" />
      <h2>IIT MADRAS</h2>
    </div>
    <i id="hamburger" class="fas fa-bars"></i>
    <nav>
      <a href="./">Dashboard</a>
      <a href="./credits.php" class="active">Credits</a>
      <a href="./events/">Events</a>
      <a href="../logout.php">Logout</a>
    </nav>
  </header>

</body>


<div id="wrapper">

  <section class="jumbotron" id="select">
    <h3>SELECT USERS</h3>

    <form action="" method="GET">
      <ul>
        <li>
          <label for="id">ID</label>
          <select name="id_select" id="id_select">
            <?php include './utils/string_filter.php' ?>
          </select>

          <input type="text" id="id" name="id" value="<?= htmlspecialchars($_GET['id'] ?? '') ?>" />

        </li>


        <li>
          <label for="credits">Credits</label>
          <select name="credits_select" id="credits_select">
            <?php include './utils/number_filter.php' ?>
          </select>
          <input type="number" name="credits" id="credits" value="<?= htmlspecialchars($_GET['credits'] ?? '') ?>" />
        </li>
      </ul>
      <input type="submit" value="Submit" />

    </form>
  </section>

  <?php if ($users): ?>

    <form action="" method="POST" class="jumbotron" id="edit">
      <h3>MASS EDIT</h3>

      <ul>
        <li>

          <select name="mass_edit_select" id="mass_edit_select">
            <option value="add">Add Credits by</option>
            <option value="set">Set Credits to</option>
          </select>

          <input type="number" name="credits"  required />
        </li>

      </ul>
      <button type="button" id="select_all_btn">Select All</button>
      <button type="button" id="deselect_all_btn">Deselect All</button>

      <input type="submit" value="Edit" disabled/>
    </form>

    <table id="credits_sheet" class="table_records">
      <thead>
        <tr>
          <th></th>
          <th>ID</th>
          <th>Name</th>
          <th>Credits</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($users as $user) : ?>
          <tr>
            <td><input type="checkbox" form="edit" name="u_<?= htmlspecialchars($user['id']) ?>"></td>
            <td><?= htmlspecialchars(strtoupper($user['id'])) ?> </td>
            <td><?= htmlspecialchars(ucwords($user['name'])) ?> </td>
            <td><?= htmlspecialchars($user['credits']) ?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<script src="../scripts/TableRecords.js"></script>

<script src="../scripts/credits.js"></script>

</html>