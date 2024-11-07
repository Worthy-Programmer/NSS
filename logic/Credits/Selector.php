<?php

namespace Fahd\NSS\Credits;

use Fahd\NSS\DB as DB;
use Fahd\NSS\Response;
use Fahd\NSS\Status;

class Selector
{

  const USER_TABLE_NAME = "user";
  readonly array $result;  

  private DB $db;
  public function __construct(public string $id_regexp) {}

  public function select(): void {
    $this->db = new DB();
    $this->db->connect();

    $query = sprintf("SELECT id, name, credits FROM user WHERE user REGEXP '%s'", $this->id_regexp);
    $res = $this->db->conn->query($query);

    $this->result = $res->fetch_assoc();
  }

  public function respond():bool {
    if(!$this->result) return false;
    Response::respond(Status::OK, $this->result);
    return true;
  }
}
