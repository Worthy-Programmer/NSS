<?php

namespace NSS\Events;

use NSS\Database\DB;
use DateTime;
use NSS\CRUD;
use NSS\TableRecords;

class Event implements CRUD
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

  public function read(): bool
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

  public function create (): void
  {
    DB::query("INSERT INTO `$this->table_name` (`name`, `start_datetime`, `end_datetime`, `venue`, `credits`, `max_vol`, `content`) VALUES ('%s', '%s', '%s', '%s', %d, %d, '%s')", $this->name, $this->startDatetimeString, $this->endDatetimeString, $this->venue, $this->credits, $this->max_vol, $this->content);
    $this->getIDFromDetails();
  }

  public function delete() {
    DB::query("DELETE FROM `$this->table_name` WHERE `id`=%d", $this->id);
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

    $query = sprintf("SELECT user.id, user.name, user_event.attendance FROM user JOIN user_event ON user.id = user_event.user_id WHERE user_event.event_id = %d", $this->id);
    $res = $db->conn->query($query);

    $this->users = $res->fetch_all();
    $this->userCount = $res->num_rows;
  }

  public function removeUsers(array $ids) {
    DB::query("DELETE FROM user_event WHERE user_id IN ". TableRecords::commaSeparatedStringsForIN(count($ids)). " AND event_id = %d", ...array_merge($ids, [$this->id]));
  }

  public function markAtttendance(array $ids)
  {
    DB::query("UPDATE user_event SET attendance = TRUE WHERE user_id IN " . TableRecords::commaSeparatedStringsForIN(count($ids)) . " AND event_id = %d", ...array_merge($ids, [$this->id]));
  }

  public function unmarkAtttendance(array $ids)
  {
    DB::query("UPDATE user_event SET attendance = FALSE WHERE user_id IN " . TableRecords::commaSeparatedStringsForIN(count($ids)) . " AND event_id = %d", ...array_merge($ids, [$this->id]));
  }



  public function addUsers(array $ids) {
    $values = array_reduce($ids, fn($array, $id) => array_merge($array, [strtolower($id), $this->id]), []);

    // ( ('%s', %d), ('%s', %d) , ('%s', %d) ) -> IT WILL BE LIKE THIS. BUT WE DON'T NEED THE OUTER ()
    $comma_separated  = TableRecords::commaSeparatedValuesForIN("('%s', %d)", count($ids));
    $comma_separated = substr($comma_separated, 1,  strlen($comma_separated) - 2);
    $query = "INSERT INTO user_event (user_id, event_id) VALUES " .  $comma_separated;
    DB::query($query , ...$values);
  }


  public function formatDate() {
    $this->startDatetimeString = $this->startDatetime->format('Y-m-d\TH:i');
    $this->endDatetimeString = $this->endDatetime->format('Y-m-d\TH:i');
  }
}
