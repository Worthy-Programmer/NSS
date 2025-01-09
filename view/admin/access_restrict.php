<?php
use NSS\Auth\SessionHandler;
use NSS\Users\User;

if (!SessionHandler::isLoggedIn()) header("Location: ../login.php");

$session = new SessionHandler();
$user = new User($session->username);
$user->read();


if($user->isVolunteer()) {
  header("HTTP/1.0 404 Not Found");
  exit;
}