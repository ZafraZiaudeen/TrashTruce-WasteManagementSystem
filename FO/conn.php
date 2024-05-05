<?php

class Conn{
    public static function GetConnection()
    {
        try{
            $dsn="mysql:dbname=trashtruce";
            $username="trashtruce";
            $password="trashtruce";
            $conn=new PDO($dsn,$username,$password);
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            return $conn;
        }catch(Exception $e){
            throw $e;
        }
    }
}
?>