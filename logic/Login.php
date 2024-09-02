<?php
namespace Fahd\NSS;

require '../vendor/autoload.php';


use Fahd\NSS\DB as DB;

class Login {
  private DB $db;

  public function __construct(private string $username, private string $password ) {}


  public function isCredsRight(): bool {
    $this->db = new DB ();
    $this->db->connect();
    $this->cleanCred();

    $query = sprintf("SELECT * FROM pwd WHERE id='%s' LIMIT 1", $this->username);
    $res = $this->db->conn->query($query);

    if ($res->num_rows === 0) return false;

    $row = $res->fetch_assoc();
    $pwd = $row['pwd'];

    return password_verify($this->password, $pwd);
  }

  private function cleanCred(): void {
    $this->username = $this->db->escape(strtolower($this->username));
  }
}