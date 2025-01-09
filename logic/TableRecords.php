<?php

namespace NSS;

use NSS\Database\DB;

class TableRecords
{

  protected string $table;
  public array $colType;
  public array $colValue;
  public array $colSelect;

  public function __construct(public array $ids = []) {}

  public function get(): array
  {
    $query = "SELECT * FROM $this->table WHERE ";
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

  public function addIntField(string $field, int $increment): bool
  {
    return DB::query("UPDATE $this->table SET $field = $field + %d WHERE id IN " . self::commaSeparatedStringsForIN(count($this->ids)), $increment, ...$this->ids);
  }

  public function setIntField(string $field, int $value): bool
  {
    return DB::query("UPDATE $this->table SET $field = %d WHERE id IN " . self::commaSeparatedStringsForIN(count($this->ids)), $value, ...$this->ids);
  }

  public function delete()
  {
    return DB::query("DELETE FROM $this->table WHERE id IN " . self::commaSeparatedStringsForIN(count($this->ids)), ...$this->ids);
  }

  public static function filterFields(array $fields = [], string $prefix = 'u_', string $activeFieldValue = "on"): array
  {
    $ids = [];
    $fields = $fields ?: $_POST;
    foreach ($fields as $key => $val) {
      if (!(str_starts_with($key, $prefix) && $val == $activeFieldValue)) continue;
      $ids[] = substr($key, strlen($prefix));
    }
    return $ids;
  }

  private static function genIntQuery(string $name, string $value, string $select): array
  {
    $query = $name . " ";
    if ($value === "") return [$query . "IS NOT NULL", []];

    $query .= match ($select) {
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

  public static function commaSeparatedStringsForIN(int $count): string
  {
    // To create like this: ('%s','%s','%s')
    return self::commaSeparatedValuesForIN("'%s'", $count);
  }

  public static function commaSeparatedValuesForIN(string $value, int $count): string
  {
    // To create like this: ('%s','%s','%s')
    return "(" . rtrim(str_repeat("$value,", $count), ',') . ")";
  }
}
