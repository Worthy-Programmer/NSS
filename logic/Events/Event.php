<?php

namespace Fahd\NSS\Events;

use Fahd\NSS\Database\DB;
use DateTime;

class Event
{
  private string $table_name = "event";
  public string $name;
  public \DateTime $startDatetime;
  public \DateTime $endDatetime;
  public string $venue;
  public int $credits;
  public int $max_vol;
  public string $content;

  public string $startDatetimeString;
  public string $endDatetimeString;
  
  public array $users;
  public int $userCount;

  public function __construct(public int $id) {}

  public function get(): bool
  {
    $res = DB::query("SELECT * FROM $this->table_name WHERE id=%d LIMIT 1", $this->id);
    $row = $res->fetch_assoc();

    if ($res->num_rows === 0) return false;

    $this->name = $row['name'];
    $this->startDatetime = new DateTime($row['start_datetime']);
    $this->endDatetime = new DateTime($row['end_datetime']);
    $this->venue = $row['venue'];
    $this->credits = $row['credits'];
    $this->max_vol = $row['max_vol'];
    $this->content = $row['content'];

    $this->formatDate();
    return true;
  }

  public function update(): void
  {
    DB::query("UPDATE `$this->table_name` SET `name` = '%s', `start_datetime` = '%s', `end_datetime` = '%s', `venue` = '%s', `credits` = %d, `max_vol` = %d,  `content` = '%s' WHERE `id` = %d", $this->name, $this->startDatetimeString, $this->endDatetimeString, $this->venue, $this->credits, $this->max_vol, $this->content, $this->id);
  }

  public function insert (): void
  {
    DB::query("INSERT INTO `$this->table_name` (`name`, `start_datetime`, `end_datetime`, `venue`, `credits`, `max_vol`, `content`) VALUES ('%s', '%s', '%s', '%s', %d, %d, '%s')", $this->name, $this->startDatetimeString, $this->endDatetimeString, $this->venue, $this->credits, $this->max_vol, $this->content);
    $this->getIDFromDetails();
  }

  private function getIDFromDetails():int
  {
    $res = DB::query("SELECT id FROM `$this->table_name` WHERE `name` = '%s' AND `start_datetime` = '%s' AND `end_datetime` = '%s' AND `venue` = '%s' AND `credits` = %d AND `max_vol` = %d AND `content` = '%s' LIMIT 1", $this->name, $this->startDatetimeString, $this->endDatetimeString, $this->venue, $this->credits, $this->max_vol, $this->content);
    $row = $res->fetch_assoc();
    $this->id = (int) $row['id'];
    return $this->id;
  }

  public function getUsers(): void{
    $db = new DB();
    $db->connect();

    $query = sprintf("SELECT user.id, user.name, user.credits FROM user JOIN user_event ON user.id = user_event.user_id JOIN event ON event.id = user_event.event_id WHERE event.id = %d", $this->id);
    $res = $db->conn->query($query);

    $this->users = $res->fetch_all();
    $this->userCount = $res->num_rows;
  }

  public function formatDate() {
    $this->startDatetimeString = $this->startDatetime->format('Y-m-d\TH:i');
    $this->endDatetimeString = $this->endDatetime->format('Y-m-d\TH:i');
  }

  // static function getEvents(string $name_exp): array {
  //   $db = new DB();
  //   $db->connect();

  //   // $id_exp = $id_exp or '*';
  //   $name_exp = $db->escape($name_exp) or '*';

  
  //   // $query = sprintf("SELECT * FROM WHERE `id`=%d AND `name` LIKE  LIMIT 50", $id_exp, $name_exp);
  //   $res = $db->conn->query($query);

  //   return $res->fetch_all();
  // }
}
