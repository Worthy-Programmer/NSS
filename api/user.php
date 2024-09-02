<?php

use Fahd\NSS\Response;
use Fahd\NSS\SessionHandler;
use Fahd\NSS\Status;
use Fahd\NSS\User;

require '../vendor/autoload.php';

$session = new SessionHandler();
if(!$session::exists()) Response::respond(Status::Error, "User has not logged in");

$user = new User($session->username);

Response::respond(Status::OK, $user);