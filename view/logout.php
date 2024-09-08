<?php

use Fahd\NSS\CookieHandler;

require '../vendor/autoload.php';

$cookie = new CookieHandler();
$cookie->destroy();
session_start();
session_unset();
session_destroy();


// var_dump($_SESSION);
// ob_start();
header("Location: ./login.php");

