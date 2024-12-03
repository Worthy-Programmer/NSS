<?php
use Fahd\NSS\Auth\SessionHandler;
use Fahd\NSS\Users\User;

if (!SessionHandler::isLoggedIn()) header("Location: ../login.php");

$session = new SessionHandler();
$user = new User($session->username);
$user->getDetails();


if($user->isVolunteer()) {
  header("HTTP/1.0 404 Not Found");
  exit;
}