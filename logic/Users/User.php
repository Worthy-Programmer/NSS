<?php

namespace NSS\Users;

use NSS\CRUD;
use NSS\Database\DB;
use NSS\Exception;

class User implements CRUD {
  public string $name;
  public int $credits;
  public int $role;

  public function __construct(public string $id) {}
  
  public function read() {
    $res = DB::query("SELECT * FROM user WHERE id='%s' LIMIT 1", $this->id);
    
    $row = $res->fetch_assoc();
    $this->name = $row['name'];
    $this->credits = + $row['credits'];
    $this->role = + $row ['role'];
  }

  public function update() {
    return DB::query("UPDATE user SET name = '%s', credits = %i, role = %i WHERE id = '%s'", $this->name, $this->credits, $this->role, $this->id);
  }

  public function delete() {
    return DB::query("DELETE FROM user WHERE id = '%s'", $this->id);
  }

  public function create() {
    return DB::query("INSERT INTO user VALUES ('%s', '%s', %d, %d)", strtolower($this->id), $this->name, $this->credits, $this->role);
  }

  public function getEvents() {
    $sql = "SELECT event.name, event.credits, user_event.attendance  FROM user_event JOIN event ON user_event.event_id =  event.id WHERE user_event.attendance = FALSE AND user_event.user_id = '%s'";
    $conn = DB::query($sql, $this->id);

    return $conn->fetch_assoc();
  }

  public function isVolunteer()
  {
    return $this->role === 0;
  }

  // BELOW 2 FUNCTIONS HAVE NOT BEEN USED YET
  // public function addCredits(int $increment): bool {
  //   $res = DB::query("UPDATE user SET credits = credits + %i WHERE id = '%s'", $increment , $this->name);
  //   if ($res) $this->credits += 1;
  //   return $res;
  // }

  // public function setCredits(int $credits): bool {
  //   $res = DB::query("UPDATE user SET credits =  %i WHERE id = '%s'", $credits, $this->name);
  //   if ($res) $this->credits = $credits;
  //   return $res;
  // }

  static function getUserFromSession() {
    $ses = new \NSS\Auth\SessionHandler;
    if (!$ses->exists()) throw new Exception\UnauthorizedAccess;

    $user = new User($ses->username);
    return $user;
  }

  static function getAdminFromSession() {
    $user = self::getUserFromSession();
    $user->read();
    if($user->isVolunteer()) throw new Exception\Forbidden;
    return $user;
  }
}