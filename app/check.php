<?php

if(isset($_POST['id'])){
    require '../db_conn.php';
    global $database;

    $id = $_POST['id'];

    if(empty($id)){
       echo 'error';
    }else {
        $todos = $database->query("SELECT id, checked FROM todos WHERE id='$id'");
        $todo = $todos->fetch_assoc();
        $uId = $todo['id'];

        $checked = $todo['checked'];


        $uChecked = $checked ? 0 : 1;

        $res = $database->query("UPDATE todos SET checked=$uChecked WHERE id=$uId");

        if($res){
            echo $checked;
        }else {
            echo "error";
        }
        $database->conn = null;
        header("Location: ../index.php");

        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}