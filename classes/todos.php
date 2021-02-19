<?php 

class Todos{
    
    public function find_todos(){
        global $database;
        $sql = "SELECT * from todos ORDER BY date_time DESC";
        $result = $database->query($sql);
        return $result;
    }
    public function rowCount($sql){
        global $database;

        $result = $database->query($sql);
        return mysqli_num_rows($result);
    }
    public function add_todo($title){
        global $database;
        $stmt = $database->query("INSERT INTO todos(title) VALUE('$title')");
        header("Location: ../index.php"); 
    }
    public function completed(){
        global $database;
        $sql = "SELECT * from todos WHERE checked='1' ORDER BY date_time DESC";
        $result = $database->query($sql);
        return $result;
    }
    public function clear_all(){
        global $database;
        $sql = "DELETE FROM todos";
        $result = $database->query($sql);
        return $result;
    }
}
$todos = new Todos();

?>