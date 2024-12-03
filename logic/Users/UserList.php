<?php

namespace Fahd\NSS\Users;

use Fahd\NSS\Database\DB;

class UserList
{

  static function getUsers(string $idSelect, string $id, string $creditsSelect, ?int $credits): array
  {
    $count = 0;
    $id_arr = $id === "" ? []: [$id];
    $credits_arr = [$credits ?? ""];

    if(in_array($idSelect, ["IN", "NOT IN"])) {
      $id_arr = explode(',', $id);
      $count = count($id_arr);
    }

    $idQuery = self::genIdQuery($id !== "" ? $idSelect: "", $count);
    $creditsQuery = self::genCreditsQuery(is_null($credits)  ? "": $creditsSelect);

    $res = DB::query("SELECT id, name, credits FROM user WHERE id $idQuery AND credits $creditsQuery", ...$id_arr, ...$credits_arr);
  
    return $res->fetch_all(MYSQLI_ASSOC);
  }

  private static function genCreditsQuery(string $creditsSelect): string {
    return match($creditsSelect) {
      "=", ">", ">=", "<", "<=", "!=" => "$creditsSelect %d",
      default => "IS NOT NULL"
    };
  }

  private static function genIdQuery(string $idSelect, int $count = 0): string
  {
    $qs = "'%s'";
    return match ($idSelect) {
      "=", "!=", "LIKE", "NOT LIKE", "REGEXP" => "$idSelect $qs",
      "IN", "NOT IN" =>  $idSelect. " " . self::commaSeparatedStringsForIN($count),
      default => "IS NOT NULL"
    };
  }



  public function __construct(public array $ids = []) {}

  public function addCredits(int $increment): bool
  {
    return DB::query("UPDATE user SET credits = credits + %d WHERE id IN ". self::commaSeparatedStringsForIN(count($this->ids)), $increment, ...$this->ids);
  }

  public function setCredits(int $credits): bool
  {
    return DB::query("UPDATE user SET credits = %d WHERE id IN " . self::commaSeparatedStringsForIN(count($this->ids)), $credits, ...$this->ids);
  }

  public static function filterFields(string $prefix = 'u_', string $activeFieldValue = "on"): UserList {
    $ids = [];
    foreach($_POST as $key => $val) {
      if(!(str_starts_with($key, $prefix) && $val == $activeFieldValue)) continue;
      $ids[] = substr($key, strlen($prefix));
    }
    return new UserList($ids);
  } 

  private static function commaSeparatedStringsForIN (int $count): string
  {
    // To create like this: ('%s','%s','%s')
    return "(" . rtrim(str_repeat("'%s',", $count), ','). ")";
  }
}
