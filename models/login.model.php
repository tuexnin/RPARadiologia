<?php

require_once "connection.php";

class LoginModel{

    static public function getUser($usuario){
        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
        return Connection::executeQuery($sql);
    }

}