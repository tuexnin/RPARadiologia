<?php

require_once "connection.php";

class PacientesModel{
    
    static public function getData (){
        $sql = "SELECT * FROM pacientes ORDER BY idpaciente ASC";
        return Connection::executeQuery($sql);
    }

    static public function getDataRegistro ($idpaciente){
        $sql = "select ra.fecha_atencion, ra.turno, ra.n_solicitud, concat(p2.nombres, ' ', p2.apellidos) as profesional, a.nombre as area, ra.cantidad_ex, ra.observaciones
        from reg_atenciones ra 
        inner join pacientes p ON ra.paciente_id = p.idpaciente 
        inner join profesionales p2 on ra.profecional_id = p2.idprofesional 
        inner join areas a on ra.area_id = a.idarea 
        where ra.paciente_id = '$idpaciente' order by ra.fecha_atencion asc";
        return Connection::executeQuery($sql);
    }

    static public function validarDni($dni){
        $sql = "SELECT * FROM pacientes WHERE dni = '$dni'";
        return Connection::executeQuery($sql);
    }

    static public function insertar($dni, $nombres, $apellidos, $fecha_reg){
        $sql = "INSERT INTO pacientes (dni, nombres, apellidos, fecha_reg) VALUES (:dni, :nombres, :apellidos, :fecha_reg)";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('dni', $dni, PDO::PARAM_STR);
        $stmt->bindParam('nombres', $nombres, PDO::PARAM_STR);
        $stmt->bindParam('apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam('fecha_reg', $fecha_reg, PDO::PARAM_STR);
        
        return $stmt->execute() ? $link->lastInsertId() : "error";
    }

    static public function editar($idpaciente, $dni, $nombres, $apellidos){
        $sql = "UPDATE pacientes SET dni = :dni, nombres = :nombres, apellidos = :apellidos WHERE idpaciente = :idpaciente";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('idpaciente', $idpaciente, PDO::PARAM_STR);
        $stmt->bindParam('dni', $dni, PDO::PARAM_STR);
        $stmt->bindParam('nombres', $nombres, PDO::PARAM_STR);
        $stmt->bindParam('apellidos', $apellidos, PDO::PARAM_STR);
        return $stmt->execute();
    }

    static public function mostrar($idpaciente){
        $sql = "SELECT * FROM pacientes WHERE idpaciente = '$idpaciente'";
        return Connection::executeQuery($sql);
    }

    static public function cantidad(){
        $sql = "SELECT count(p.idpaciente) as cantidad FROM pacientes p ";
        return Connection::executeQuery($sql);
    }

}