<?php

header("Content-Type:application/json");

use NSS\Utils\Response;
use NSS\Auth\SessionHandler;
use NSS\Utils\Status;
use NSS\Users\User;

require '../vendor/autoload.php';

$session = new SessionHandler();
if(!$session::exists()) Response::respond(Status::Error, "User has not logged in");

$user = new User($session->username);
$user->read();

Response::respond(Status::OK, $user);