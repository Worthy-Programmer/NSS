<?php

namespace Fahd\NSS;

require_once "../vendor/autoload.php";


class User {
  public string $name;
  public int $credits;

  public function __construct(public string $id) {}
  
  public function getDetails() {
    $db = new DB();
    $db->connect();

    $query = sprintf("SELECT * FROM user WHERE id='%s' LIMIT 1", $db->escape($this->id));
    $res = $db->conn->query($query);

    $row = $res->fetch_assoc();

    $this->name = $row['name'];
    $this->credits = + $row['credits'];
  }

  // public function setPFP() {

  // }
}