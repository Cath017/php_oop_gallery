<?php
require_once('new_config.php');

class Database {
  public $connection;
  public $db;

  function __construct(){
    $this->db = $this->open_db_connection();
  }

  public function open_db_connection(){
    // $this->connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    if($this->connection->connect_errno) {
      die('Database connection failed' . $this->connection->connect_error);
    } else {
      return $this->connection;
    }
  }

  public function query($sql){
    $result = $this->db->query($sql);
    $this->confirm_query($result);
    return $result;
  }

  private function confirm_query($result){
    if(!$result){
      die('Query Failed' . $this->db->error);
    }
  }

  public function escape_string($string){
    return $this->db->real_escape_string($string);
  }

  public function insert_id(){
    return $this->db->insert_id;
  }

  public function the_insert_id(){
    return mysqli_insert_id($this->db);
  }

}
$database = new Database();



?>