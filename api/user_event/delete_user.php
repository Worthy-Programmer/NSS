<?php

use NSS\Events\Event;
use NSS\Exception;
use NSS\TableRecords;
use NSS\Utils\Response;
use NSS\Utils\Status;
use NSS\Users\User;

header("Content-Type:application/json");
header("Access-Control-Allow-Methods: POST");

require '../../vendor/autoload.php';

Exception\Handler::handle();
User::getAdminFromSession();

if (!isset($_POST['event_id'])) throw new Exception\InadequateData;

$event = new Event($_POST['event_id']);
$user_ids = TableRecords::filterFields();

if (!count($user_ids)) throw new Exception\InadequateData;
$event->removeUsers($user_ids);

Response::respond(Status::OK, "Records Deleted");