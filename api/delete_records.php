<?php
header("Content-Type:application/json");

use NSS\Users\User;
use NSS\Users\UserRecords;
use NSS\Events\EventRecords;
use NSS\Exception;
use NSS\Utils\Response;
use NSS\Utils\Status;


require '../vendor/autoload.php';

Exception\Handler::handle();
User::getAdminFromSession();

if (!isset($_POST['record'])) throw new Exception\InadequateData;

if (!in_array($_POST['record'], ["user", "event"]))   throw new Exception\InvalidData;

$record = $_POST['record'];
$ids = UserRecords::filterFields();
$handler = $record == 'user' ? new UserRecords($ids) : new EventRecords($ids);
$handler->delete();

Response::respond(Status::OK, "Records Deleted");