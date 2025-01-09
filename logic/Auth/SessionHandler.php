<?php

namespace NSS\Auth;

class SessionHandler {
  public string $username;
  function __construct() {
    if(CookieHandler::exists() && !SessionHandler::exists()) {$this->create();return;} ;
    if(SessionHandler::exists()) {$this->setUsername();};
  }

  function create() {
    $this->username =  $_COOKIE['id'];
    if(!isset($_SESSION)) session_start();
    $_SESSION['id'] = $this->username;
  }

  static function exists() {
    if (!isset($_SESSION)) session_start();

    return isset($_SESSION['id']);
  }


  private function setUsername() {
    if (!isset($_SESSION)) session_start();
    $this->username = $_SESSION['id'];
  }

  static public function isLoggedIn()
  {
    $session = new SessionHandler();
    return $session::exists();
  }
}