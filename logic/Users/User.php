<?php

namespace Fahd\NSS\Users;

use Fahd\NSS\Database\DB;

class User {
  public string $name;
  public int $credits;
  private int $role;

  public function __construct(public string $id) {}
  
  public function getDetails() {
    $res = DB::query("SELECT * FROM user WHERE id='%s' LIMIT 1", $this->id);
    
    $row = $res->fetch_assoc();
    $this->name = $row['name'];
    $this->credits = + $row['credits'];
    $this->role = + $row ['role'];
  }

  public function isVolunteer() {
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
}