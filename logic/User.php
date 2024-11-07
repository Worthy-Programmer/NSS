<?php

namespace Fahd\NSS;



class User {
  public string $name;
  public int $credits;
  private int $role;

  public function __construct(public string $id) {}
  
  public function getDetails() {
    $db = new DB();
    $db->connect();

    $query = sprintf("SELECT * FROM user WHERE id='%s' LIMIT 1", $db->escape($this->id));
    $res = $db->conn->query($query);

    $row = $res->fetch_assoc();

    $this->name = $row['name'];
    $this->credits = + $row['credits'];
    $this->role = + $row ['role'];
  }

  public function isVolunteer() {
    return $this->role === 0;
  }

  static function getUsers(string $name_exp): array {
    $db = new DB();
    $db->connect();

    $query = sprintf("SELECT id, name, credits FROM user WHERE id LIKE '%s'", $db->escape($name_exp));
    $res = $db->conn->query($query);
    return $res->fetch_all();
  }

}