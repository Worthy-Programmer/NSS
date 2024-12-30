<?php

namespace Fahd\NSS;

use Fahd\NSS\Database\DB;

abstract class TableRecords {

  protected string $table_name; public array $colType; public array $colValue; public array $colSelect;

  public function getRecords(): array
  {
    $query = "SELECT * FROM $this->table_name WHERE ";
    $values = [];

    foreach ($this->colType as $key => $val) {
      $res = match ($val) {
        "int" => self::genIntQuery($key, $this->colValue[$key], $this->colSelect[$key]),
        "string" => self::genStringQuery($key, $this->colValue[$key], $this->colSelect[$key]),
        default => ["", []]
      };

      array_push($values, ...$res[1]);
      $query .= $res[0] . " AND ";
    }

    $query .= 1;

    $res = DB::query($query, ...$values);
    return $res->fetch_all(MYSQLI_ASSOC);
  }

  public static function filterFields(string $prefix = 'u_', string $activeFieldValue = "on"): array
  {
    $ids = [];
    foreach ($_POST as $key => $val) {
      if (!(str_starts_with($key, $prefix) && $val == $activeFieldValue)) continue;
      $ids[] = substr($key, strlen($prefix));
    }
    return $ids;
  }

  private static function genIntQuery(string $name, string $value, string $select): array {
    $query = $name . " ";
    if ($value === "") return [$query . "IS NOT NULL", []];

    $query .= match($select) {
      "=", ">", ">=", "<", "<=", "!=" => "$select %d",
      default => "IS NOT NULL"
    };

    return [$query, [$value]];
  }

  private static function genStringQuery(string $name, string $value, string $select): array
  {
    $count = 0;
    $arr = $value === "" ? [] : [$value];
    $query = $name . " ";

    if ($value === "") return [$query . "IS NOT NULL", []];


    if (in_array($select, ["IN", "NOT IN"])) {
      $arr = explode(',', $value);
      $count = count($arr);
    }

    $qs = "'%s'";
    $query .=  match ($select) {
      "=", "!=", "LIKE", "NOT LIKE", "REGEXP" => "$select $qs",
      "IN", "NOT IN" =>  $select . " " . self::commaSeparatedStringsForIN($count),
      default => "IS NOT NULL"
    };

    return [$query, $arr];
  }

  protected static function commaSeparatedStringsForIN(int $count): string
  {
    // To create like this: ('%s','%s','%s')
    return "(" . rtrim(str_repeat("'%s',", $count), ',') . ")";
  }
}