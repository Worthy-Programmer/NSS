<?php
header("Content-Type:application/json");

require '../vendor/autoload.php';

use Fahd\NSS\CookieHandler;
use Fahd\NSS\SessionHandler;
use Fahd\NSS\Login;
use Fahd\NSS\Response;
use Fahd\NSS\Status;

if(!(isset($_POST['id']) && isset($_POST['pwd']))) Response::respond(Status::Error, "Error: Inadequate Prompt");

$login = new Login ($_POST['id'], $_POST['pwd']);
$isValid = $login->isCredsRight();

if ($isValid) {
  $res = new Response(Status::OK, "Valid Credentials");
  CookieHandler::create($_POST['id']);
  new SessionHandler();
} 
else $res = new Response(Status::NotOK, "Invalid Roll Number / Password");


$res->send();