<?php

header("Content-Type:application/json");

use Fahd\NSS\Utils\Response;
use Fahd\NSS\Auth\SessionHandler;
use Fahd\NSS\Utils\Status;
use Fahd\NSS\Users\User;

require '../vendor/autoload.php';

$session = new SessionHandler();
if(!$session::exists()) Response::respond(Status::Error, "User has not logged in");

$user = new User($session->username);
$user->getDetails();

Response::respond(Status::OK, $user);