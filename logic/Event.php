<?php

namespace Fahd\NSS;

use DateTime;

class Event
{
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

  public function getData(): bool
  {
    $db = new DB();
    $db->connect();

    $query = sprintf("SELECT * FROM event WHERE id=%d LIMIT 1", $this->id);
    $res = $db->conn->query($query);

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

  static function getEvents(string $name_exp): array {
    $db = new DB();
    $db->connect();

    $id_exp = $id_exp or '*';
    $name_exp = $db->escape($name_exp) or '*';

  
    $query = sprintf("SELECT * FROM WHERE `id`=%d AND `name` LIKE  LIMIT 50", $id_exp, $name_exp);
    $res = $db->conn->query($query);

    return $res->fetch_all();
  }
}
