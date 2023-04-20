<?php

require_once "connection.php";

class AreasModel{
    
    static public function getData (){
        $sql = "SELECT * FROM areas ORDER BY idarea ASC";
        return Connection::executeQuery($sql);
    }

    static public function getSelectArea (){
        $sql = "select a.idarea, a.nombre from areas a where a.estado = 0";
        return Connection::executeQuery($sql);
    }

    static public function insertar($nombre, $fecha_reg){
        $sql = "INSERT INTO areas (nombre, fecha_reg) VALUES (:nombre, :fecha_reg)";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam('fecha_reg', $fecha_reg, PDO::PARAM_STR);
        return $stmt->execute();
    }

    static public function editar($idarea, $nombre){
        $sql = "UPDATE areas SET nombre = :nombre WHERE idarea = :idarea";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('idarea', $idarea, PDO::PARAM_STR);
        $stmt->bindParam('nombre', $nombre, PDO::PARAM_STR);
        return $stmt->execute();
    }

    static public function mostrar($idarea){
        $sql = "SELECT * FROM areas WHERE idarea = '$idarea'";
        return Connection::executeQuery($sql);
    }

    static public function cantidad(){
        $sql = "SELECT count(a.idarea) as cantidad FROM areas a ";
        return Connection::executeQuery($sql);
    }

    static public function estado($idarea, $estado){
        $sql = "UPDATE areas SET estado = :estado WHERE idarea = :idarea";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('idarea', $idarea, PDO::PARAM_STR);
        $stmt->bindParam('estado', $estado, PDO::PARAM_STR);
        if($stmt->execute()){
            if($estado == 0){
                $response = array(
                    "icono" => "success",
                    "mensaje" => "Area Activada"
                );
                return $response;
            }else{
                $response = array(
                    "icono" => "success",
                    "mensaje" => "Area Desactivada"
                );
                return $response;
            }
            
        }else{
            $response = array(
                "icono" => "error",
                "mensaje" => "La accion no se pudo realizar"
            );
            return $response;
        }
    }

}