<?php

namespace NSS\Events;

use NSS\TableRecords;
use NSS\Database\DB;


class EventRecords extends TableRecords
{

  protected string $table = "event";
  public array $colType = ["id" => "int", "name" => "string"];

  public function linkUser($user_id): void
  {
    foreach ($this->ids as $event_id) {
      DB::query("INSERT INTO event_user (event_id, user_id) VALUES (%d, %d)", $event_id, $user_id);
    }
  }
}
