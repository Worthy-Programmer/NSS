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
      <h3>Credits</h3>
      <ul>
        <li><a href="">Sheet</a></li>
        <li><a href="">Edit Credits</a></li>
      </ul>
    </section>


    <section class="jumbotron">
      <h3>Events</h3>
      <ul>
        <li><a href="">Add Event</a></li>
        <li><a href="">Event List</a></li>
        <li><a href="">Blog post</a></li>
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