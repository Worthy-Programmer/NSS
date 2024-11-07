<?php
namespace Fahd\NSS;

class DB {
  static private string $host;
  static private string $username;
  static private string $password;
  static private string $dbName;

  public \Mysqli $conn;

  public function __construct($file='settings.ini')
  {
    if(isset(DB::$host)) return;
    if (!$settings = parse_ini_file($file, TRUE)) throw new \exception('Unable to open ' . $file . '.');

    $db = $settings['database'];
    $this::$host = $db['host'];
    $this::$username = $db['username'];
    $this::$password = $db['password'];
    $this::$dbName = $db['db'];
  }


  public function __destruct()
  {
    $this->conn->close();
  }

  public function connect(): void {
    $this->conn = new \mysqli($this::$host, $this::$username, $this::$password, $this::$dbName);

    if ($this->conn->connect_error) {
      throw new \exception("Connection failed: " . $this->conn->connect_error);
    }
  }

  public function escape(string $str): string {
    return $this->conn->real_escape_string($str);
  }
}
