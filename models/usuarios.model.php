<?php

require_once "connection.php";

class UsuariosModel{
    
    static public function getData (){
        $sql = "SELECT * FROM usuarios ORDER BY idusuario ASC";
        return Connection::executeQuery($sql);
    }

    static public function insertar($dni, $nombres, $apellidos, $celular, $email, $usuario, $password, $fecha_reg, $imagen, $rol){
        $sql = "INSERT INTO usuarios (dni, nombres, apellidos, celular, correo, usuario, password, fecha_reg, foto, rol) VALUES (:dni, :nombres, :apellidos, :celular, :correo, :usuario, :password, :fecha_reg, :foto, :rol)";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('dni', $dni, PDO::PARAM_STR);
        $stmt->bindParam('nombres', $nombres, PDO::PARAM_STR);
        $stmt->bindParam('apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam('celular', $celular, PDO::PARAM_STR);
        $stmt->bindParam('correo', $email, PDO::PARAM_STR);
        $stmt->bindParam('usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam('password', $password, PDO::PARAM_STR);
        $stmt->bindParam('fecha_reg', $fecha_reg, PDO::PARAM_STR);
        $stmt->bindParam('foto', $imagen, PDO::PARAM_STR);
        $stmt->bindParam('rol', $rol, PDO::PARAM_STR);
        return $stmt->execute();
    }

    static public function editar($idusuario, $dni, $nombres, $apellidos, $celular, $email, $usuario, $password, $imagen, $rol){
        $sql = "UPDATE usuarios SET dni = :dni, nombres = :nombres, apellidos = :apellidos, celular = :celular, correo = :correo, usuario = :usuario, password = :password, foto = :foto, rol = :rol WHERE idusuario = :idusuario";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('idusuario', $idusuario, PDO::PARAM_STR);
        $stmt->bindParam('dni', $dni, PDO::PARAM_STR);
        $stmt->bindParam('nombres', $nombres, PDO::PARAM_STR);
        $stmt->bindParam('apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam('celular', $celular, PDO::PARAM_STR);
        $stmt->bindParam('correo', $email, PDO::PARAM_STR);
        $stmt->bindParam('usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam('password', $password, PDO::PARAM_STR);
        $stmt->bindParam('foto', $imagen, PDO::PARAM_STR);
        $stmt->bindParam('rol', $rol, PDO::PARAM_STR);
        return $stmt->execute();
    }

    static public function mostrar($idusuario){
        $sql = "SELECT * FROM usuarios WHERE idusuario = '$idusuario'";
        return Connection::executeQuery($sql);
    }

    static public function eliminar($idusuario){
        $sql = "delete from usuarios where idusuario = :idusuario";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('idusuario', $idusuario, PDO::PARAM_STR);
        if($stmt->execute()){
            $response = array(
                "icono" => "success",
                "mensaje" => "Usuario eliminado"
            );
            return $response;
        }else{
            $response = array(
                "icono" => "error",
                "mensaje" => "Error: no se pudo eliminar el usuario"
            );
            return $response;
        }
    }

}