<?php

use NSS\Utils\Helper;

require_once '../../../vendor/autoload.php';

$is_create_user = false;

if (isset($_GET['id'])) {
  $user = new NSS\Users\User($_GET['id']);
  $user->read();
}

$post_array = ['id', 'name', 'credits', 'role', 'mode'];
$is_post_fields_present = Helper::isAllKeysInArray($post_array, $_POST);

if (isset($_GET['mode']) && $_GET['mode'] == 'create') $is_create_user = true;

if ($is_post_fields_present) {
  $is_create_user = $_POST['mode'] == 'create';
  $user = new NSS\Users\User($_POST['id']);
  $user->name = $_POST['name'];
  $user->credits = $_POST['credits'];
  $user->role = intval($_POST['role']);

  if (!$is_create_user)
    $user->update();
  else $user->create();

  $is_create_user = false;
}

?>

<!DOCTYPE html>
<html>
<?php (new UI\Head('Edit User | Admin Portal |', ['init.css', 'admin/index.css', 'utils/jumbotron.css', 'admin/users/edit.css']))->render() ?>

<body>
  <?php (new UI\Navbar([
    "Dashboard" => "/view/admin/",
    "Users" => "/view/admin/users/",
    "Events" => "/view/admin/events/",
    "Logout" => "/view/auth/logout.php"
  ], "Edit User"))->render(); ?>


  <div id="wrapper">
    <section class="jumbotron">
      <h3>Edit User</h3>
      <form action="" method="post">
        <input type="hidden" name="mode" value="<?= $is_create_user ? 'create' : 'edit'; ?>">


        <ul>
          <li>
            <label for="id">ID</label>
            <input type="hidden" name="id" value="<?= $user?->id ?? '' ?>">
            <input type="text" name="id" id="id" <?= $is_create_user ? '' : 'disabled' ?> value="<?= $user?->id ?? '' ?>" required>
          </li>

          <li>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="<?= $user?->name ?? '' ?>" required>
          </li>

          <li>
            <label for="credits">Credits</label>
            <input type="number" name="credits" id="credits" value="<?= $user?->credits ?? '' ?>" required>
          </li>

          <li>
            <label for="role">Role</label>
            <?php (new UI\SelectFilter('role', 'role_select', [0 => 'Volunteer', 1 => 'Admin'], $user?->role ?? ''))->render(); ?>
          </li>
          <br>
          <input type="submit" value="Submit">
        </ul>
      </form>
    </section>

    <section class="">
      <!-- TODO: Show events here later -->
    </section>
  </div>
</body>

</html>