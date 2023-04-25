<?php

require_once "connection.php";

class ProfesionalesModel{
    
    static public function getData (){
        $sql = "SELECT * FROM profesionales ORDER BY idprofesional ASC";
        return Connection::executeQuery($sql);
    }

    static public function getSelectProfesional (){
        $sql = "select p.idprofesional, concat(p.nombres, ' ', p.apellidos) as profesional from profesionales p where p.estado = 0";
        return Connection::executeQuery($sql);
    }

    static public function getDataRegistro ($idprofesional){
        $sql = "select ra.fecha_atencion, ra.turno, ra.n_solicitud, concat(p.nombres, ' ', p.apellidos) as pasiente, a.nombre as area, ra.cantidad_ex, ra.observaciones, ra.fecha_reg
        from reg_atenciones ra 
        inner join pacientes p ON ra.paciente_id = p.idpaciente 
        inner join profesionales p2 on ra.profecional_id = p2.idprofesional 
        inner join areas a on ra.area_id = a.idarea 
        where ra.profecional_id  = '$idprofesional' order by ra.fecha_atencion asc";
        return Connection::executeQuery($sql);
    }

    static public function insertar($dni, $nombres, $apellidos, $profesion, $cmp, $fecha_reg){
        $sql = "INSERT INTO profesionales (dni, nombres, apellidos, profesion, cmp, fecha_reg) VALUES (:dni, :nombres, :apellidos, :profesion, :cmp, :fecha_reg)";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('dni', $dni, PDO::PARAM_STR);
        $stmt->bindParam('nombres', $nombres, PDO::PARAM_STR);
        $stmt->bindParam('apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam('profesion', $profesion, PDO::PARAM_STR);
        $stmt->bindParam('cmp', $cmp, PDO::PARAM_STR);
        $stmt->bindParam('fecha_reg', $fecha_reg, PDO::PARAM_STR);
        return $stmt->execute();
    }

    static public function editar($idprofesional, $dni, $nombres, $apellidos, $profesion, $cmp){
        $sql = "UPDATE profesionales SET dni = :dni, nombres = :nombres, apellidos = :apellidos, profesion = :profesion, cmp = :cmp WHERE idprofesional = :idprofesional";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('idprofesional', $idprofesional, PDO::PARAM_STR);
        $stmt->bindParam('dni', $dni, PDO::PARAM_STR);
        $stmt->bindParam('nombres', $nombres, PDO::PARAM_STR);
        $stmt->bindParam('apellidos', $apellidos, PDO::PARAM_STR);
        $stmt->bindParam('profesion', $profesion, PDO::PARAM_STR);
        $stmt->bindParam('cmp', $cmp, PDO::PARAM_STR);
        return $stmt->execute();
    }

    static public function mostrar($idprofesional){
        $sql = "SELECT * FROM profesionales WHERE idprofesional = '$idprofesional'";
        return Connection::executeQuery($sql);
    }

    static public function cantidad(){
        $sql = "SELECT count(p.idprofesional) as cantidad FROM profesionales p ";
        return Connection::executeQuery($sql);
    }

    static public function estado($idprofesional, $estado){
        $sql = "UPDATE profesionales SET estado = :estado WHERE idprofesional = :idprofesional";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('idprofesional', $idprofesional, PDO::PARAM_STR);
        $stmt->bindParam('estado', $estado, PDO::PARAM_STR);
        if($stmt->execute()){
            if($estado == 0){
                $response = array(
                    "icono" => "success",
                    "mensaje" => "Pofesional Activado"
                );
                return $response;
            }else{
                $response = array(
                    "icono" => "success",
                    "mensaje" => "Pofesional Desactivado"
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