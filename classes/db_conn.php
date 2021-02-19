<?php 
require_once('../config.php');
class Database{
  public $conn = null;

  function __construct(){
    $this->open_db_connection();
  }
  public function open_db_connection(){
    $this->conn = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
    if(mysqli_connect_errno()){
      die("db connect failed". mysqli_error());
    }
  }
  public function query($sql){
    $result = mysqli_query($this->conn, $sql);
    $confirm = $this->confirm_query($result);
    return $result;

  }
  private function confirm_query($result){
    if(!$result){
      die("query failed");
    }
    return $result;
  }
  public function escape_string($string){
    $escape_string = mysqli_real_escape_string($this->conn, $string);
    return $escape_string;
  }
} 

$database = new Database();
// $sName = "localhost";
// $uName = "root";
// $pass = "";
// $db_name = "to_do_list";

// try {
//     $conn = new PDO("mysql:host=$sName;dbname=$db_name", 
//                     $uName, $pass);
//     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// }catch(PDOException $e){
//   echo "Connection failed : ". $e->getMessage();
// }

?>