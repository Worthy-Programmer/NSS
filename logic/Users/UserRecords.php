<?php

namespace Fahd\NSS\Users;

use Fahd\NSS\Database\DB;
use Fahd\NSS\TableRecords;

class UserRecords extends TableRecords
{

  public string  $table_name = "user";
  public array $colType = ["id" => "string", "credits" => "int"];

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
