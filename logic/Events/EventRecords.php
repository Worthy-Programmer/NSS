<?php

namespace Fahd\NSS\Events;

use Fahd\NSS\TableRecords;
use Fahd\NSS\Database\DB;


class EventRecords extends TableRecords
{

  public string  $table_name = "event";
  public array $colType = ["id" => "int", "name" => "string"];

  public function __construct(public array $ids = []) {}


  public function addCredits(int $increment): bool
  {
    return DB::query("UPDATE user SET credits = credits + %d WHERE id IN " . self::commaSeparatedStringsForIN(count($this->ids)), $increment, ...$this->ids);
  }

  public function setCredits(int $credits): bool
  {
    return DB::query("UPDATE user SET credits = %d WHERE id IN " . self::commaSeparatedStringsForIN(count($this->ids)), $credits, ...$this->ids);
  }
}
