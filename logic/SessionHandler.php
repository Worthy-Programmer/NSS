<?php

namespace Fahd\NSS;

class SessionHandler {
  public string $username;
  function __construct() {
    if(CookieHandler::exists() && !SessionHandler::exists()) {$this->create();} ;
  
  }

  function create() {
    if(!isset($_SESSION)) session_start();
    $this->username =  $_COOKIE['id'];
    $_SESSION['id'] = $this->username;
  }

  static function exists() {
    if (!isset($_SESSION)) session_start();

    return isset($_SESSION['id']);
  }
}