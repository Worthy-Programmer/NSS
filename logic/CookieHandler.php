<?php

namespace Fahd\NSS;

class CookieHandler {
  public string $username;

  function __construct() {
    if($this::exists()) $this->username = $_COOKIE['id'];
  }
  
  static function create(string $username) {
    setcookie('id', $username, time() + 7 *24*60*60, '/');
  }

  function destroy() {
    if ($this::exists()) setcookie('id', $this->username, 0, '/');
  }

  static function exists () {return isset($_COOKIE['id']);}
}