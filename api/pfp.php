<?php

use Fahd\NSS\PFP;
use Fahd\NSS\SessionHandler;
use Fahd\NSS\Status;

require '../vendor/autoload.php';


$ses = new SessionHandler();
if(!$ses->exists()) die;
$pfp = new PFP($ses->username);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // File details
  $file = $_FILES['pfpToUpload'];
 
  $pfp->uploadPFP($file)->send();
}


$res = $pfp->getPFPLink();


header("Content-Type:application/json");
if($res->status !== Status::OK) $res->send();


$filename = $res->response;
$file_extension = pathinfo($filename, PATHINFO_EXTENSION);
header('Content-Type: Content-Type: image/' . $file_extension);
readfile($filename);
?>