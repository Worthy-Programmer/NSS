<?php
namespace NSS\Database;

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
    // Removed get_magic_quotes_gpc check as it is deprecated
    return $this->conn->real_escape_string($str);
  }

  private function escapeArray(array $str_list): array {
    return array_map(fn($x) => $this->escape($x), $str_list);
  }

  static function query(string $format, mixed ...$values) : \mysqli_result | bool  {
    $db = new DB();
    $db->connect();

    $values = $db->escapeArray($values);

    [$placeholders, $types] = self::convertFormatStringToPreparedStatement($format);

    // echo $placeholders;
    // echo $types;
    // var_dump($values);

    $stmt = $db->conn->prepare($placeholders);
    
    if($types !== '') 
      $stmt->bind_param($types, ...$values);
    $stmt->execute();

    // echo $query;
    $res = $stmt->get_result();
    
    return $res;
    
  }

  private static function convertFormatStringToPreparedStatement(string $format): array {
    $types = '';
    $placeholders = preg_replace_callback('/("%[sidb]"|\'%[sidb]\'|%[sidb])/', function ($matches) use (&$types) {
      switch ($matches[1]) {
        case '%i':
          $types .= 'i';
          break;
        case '%d':
          $types .= 'd';
          break;
        case '%s':
        case "'%s'":
        case '"%s"':
          $types .= 's';
          break;
        case '%b':
          $types .= 'b';
          break;
        default:
          throw new \Exception("Unsupported format type: " . $matches[1]);
      }
      return '?';
    }, $format);

    return [$placeholders, $types];
  }

  public function createDatabase(string $sqlFile) {
    $this->conn = new \mysqli(DB::$host, DB::$username, DB::$password);
    $this->conn->query("CREATE DATABASE IF NOT EXISTS " . DB::$dbName);
    // $conn->query("GRANT ALL PRIVILEGES ON `$dbName`.* TO '$newUsername'@'$host'");
    $this->conn->select_db(DB::$dbName);


    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
      die("Error reading the SQL file.");
    }
    
    // Split SQL file into individual queries
    $queries = explode(';', $sql);

    // Execute each query separately
    foreach ($queries as $query) {
      $trimmedQuery = trim($query);
      if (!empty($trimmedQuery)) {
        if ($this->conn->query($trimmedQuery) === FALSE) {
          echo "Error executing query: " . $this->conn->error . "\n";
        }
      }
    }

    echo "SQL file loaded successfully.\n";
  }
}
