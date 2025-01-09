<?php

use NSS\Events\Event;
use NSS\Exception;
use NSS\TableRecords;
use NSS\Utils\Response;
use NSS\Utils\Status;
use NSS\Users\User;
use NSS\Utils\Helper;

header("Content-Type:application/json");
header("Access-Control-Allow-Methods: POST");

require '../../vendor/autoload.php';

Exception\Handler::handle();
User::getAdminFromSession();


$post_fields = ['event_id', 'role'];

if (!Helper::isAllKeysInArray($post_fields, $_POST)) throw new Exception\InadequateData;


$event = new Event($_POST['event_id']);
$user_ids = TableRecords::filterFields();

if (!count($user_ids)) throw new Exception\InadequateData;

switch ($_POST['role']) {
  case 'mark':
    $event->markAtttendance($user_ids);
    break;
  case 'unmark':
    $event->unmarkAtttendance($user_ids);
    break;
  default:
    throw new Exception\InvalidData;
    break;
}


Response::respond(Status::OK, "Records Deleted");
