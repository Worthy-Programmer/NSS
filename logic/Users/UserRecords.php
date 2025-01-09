<?php

namespace NSS\Users;

use NSS\Database\DB;
use NSS\TableRecords;

class UserRecords extends TableRecords
{

  protected string $table = "user";
  public array $colType = ["id" => "string", "credits" => "int"];

  public function linkEvents($event_id): void
  {
    foreach ($this->ids as $user_id) {
      DB::query("INSERT INTO event_user (event_id, user_id) VALUES (%d, %d)", $event_id, $user_id);
    }
  }
}
