<?php

use UI\Head;
use UI\Navbar;


require_once '../../vendor/autoload.php';
require_once "./access_restrict.php";
?>

<!DOCTYPE html>
<?php (new Head('Dashboard | Admin Portal |', ['init.css', 'admin/index.css', 'utils/jumbotron.css']))->render() ?>

<body>

  <!-- Header -->
  <?php (new Navbar([
    "Dashboard" => "/view/admin/",
    "Users" => "/view/admin/users/",
    "Events" => "/view/admin/events/",
    "Logout" => "/view/auth/logout.php"
  ], "Dashboard"))->render(); ?>






  <div id="wrapper">

    <section class="jumbotron">
      <h3>Users</h3>
      <ul>
        <li><a href="/view/admin/users/">Select / View</a></li>
        <li><a href="/view/admin/users/edit.php">Create</a></li>
      </ul>
    </section>


    <section class="jumbotron">
      <h3>Events</h3>
      <ul>
        <li><a href="/view/admin/events/">Select / View</a></li>
        <li><a href="/view/admin/events/view.php">Create</a></li>
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

</body>


</html>