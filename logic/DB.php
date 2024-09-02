<?php
namespace Fahd\NSS;

class DB {
  private string $host;
  private string $username;
  private string $password;
  private string $dbName;

  public \Mysqli $conn;

  public function __construct($file='settings.ini')
  {
    if (!$settings = parse_ini_file($file, TRUE)) throw new \exception('Unable to open ' . $file . '.');

    $db = $settings['database'];
    $this->host = $db['host'];
    $this->username = $db['username'];
    $this->password = $db['password'];
    $this->dbName = $db['db'];
  }


  public function __destruct()
  {
    $this->conn->close();
  }

  public function connect(): void {
    $this->conn = new \mysqli($this->host, $this->username, $this->password, $this->dbName);

    if ($this->conn->connect_error) {
      throw new \exception("Connection failed: " . $this->conn->connect_error);
    }
  }

  public function escape(string $str) {
    return $this->conn->real_escape_string($str);
  }
}
