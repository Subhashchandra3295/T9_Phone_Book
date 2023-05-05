<?php

class Database {
  private $host = "127.0.0.1";
  private $username = "root";
  private $password = "";
  private $database = "phonebook";

  protected $connection;

  public function __construct() {
    $this->connection = mysqli_connect($this->host, $this->username, $this->password, $this->database);

    if (!$this->connection) {
      die("Connection failed: " . mysqli_connect_error());
    }
  }

  public function __destruct() {
    mysqli_close($this->connection);
  }
}

?>