<?php

require_once "connection.php";

class AtencionModel{
    
    static public function getData (){
        $sql = "select ra.idatencion, concat(p.nombres, ' ', p.apellidos) as profesional, a.nombre as area, ra.turno, ra.n_solicitud, ra.observaciones, ra.fecha_atencion, concat(p2.nombres, ' ', p2.apellidos) as paciente, ra.fecha_reg
        from reg_atenciones ra 
        inner join profesionales p on ra.profecional_id = p.idprofesional 
        inner join areas a on ra.area_id = a.idarea 
        inner join pacientes p2 on ra.paciente_id = p2.idpaciente order by ra.idatencion desc";
        return Connection::executeQuery($sql);
    }

    static public function getDataFilter ($idprofesiona, $desde, $hasta){
        $sql = "select ra.idatencion, concat(p.nombres, ' ', p.apellidos) as profesional, a.nombre as area, ra.turno, ra.n_solicitud, ra.observaciones, ra.fecha_atencion, concat(p2.nombres, ' ', p2.apellidos) as paciente, ra.fecha_reg
        from reg_atenciones ra 
        inner join profesionales p on ra.profecional_id = p.idprofesional 
        inner join areas a on ra.area_id = a.idarea 
        inner join pacientes p2 on ra.paciente_id = p2.idpaciente
        where ra.profecional_id = '$idprofesiona' and (ra.fecha_atencion between '$desde' and '$hasta') 
        order by ra.idatencion desc";
        return Connection::executeQuery($sql);
    }

    static public function insertar($fec_aten, $turno, $n_sol, $profesional, $area, $cantEx, $obs, $fecha_reg, $paciente){
        $sql = "INSERT INTO reg_atenciones (fecha_atencion, turno, n_solicitud, profecional_id, area_id, cantidad_ex, observaciones, fecha_reg, paciente_id) VALUES (:fecha_atencion, :turno, :n_solicitud, :profecional_id, :area_id, :cantidad_ex, :observaciones, :fecha_reg, :paciente_id)";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('fecha_atencion', $fec_aten, PDO::PARAM_STR);
        $stmt->bindParam('turno', $turno, PDO::PARAM_STR);
        $stmt->bindParam('n_solicitud', $n_sol, PDO::PARAM_STR);
        $stmt->bindParam('profecional_id', $profesional, PDO::PARAM_STR);
        $stmt->bindParam('area_id', $area, PDO::PARAM_STR);
        $stmt->bindParam('cantidad_ex', $cantEx, PDO::PARAM_STR);
        $stmt->bindParam('observaciones', $obs, PDO::PARAM_STR);
        $stmt->bindParam('fecha_reg', $fecha_reg, PDO::PARAM_STR);
        $stmt->bindParam('paciente_id', $paciente, PDO::PARAM_STR);
        return $stmt->execute();
    }

    static public function editar($idatencion, $fec_aten, $turno, $n_sol, $profesional, $area, $cantEx, $obs){
        $sql = "UPDATE reg_atenciones SET fecha_atencion = :fecha_atencion, turno = :turno, n_solicitud = :n_solicitud, profecional_id = :profecional_id, area_id = :area_id, cantidad_ex = :cantidad_ex, observaciones = :observaciones WHERE idatencion = :idatencion";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('idatencion', $idatencion, PDO::PARAM_STR);
        $stmt->bindParam('fecha_atencion', $fec_aten, PDO::PARAM_STR);
        $stmt->bindParam('turno', $turno, PDO::PARAM_STR);
        $stmt->bindParam('n_solicitud', $n_sol, PDO::PARAM_STR);
        $stmt->bindParam('profecional_id', $profesional, PDO::PARAM_STR);
        $stmt->bindParam('area_id', $area, PDO::PARAM_STR);
        $stmt->bindParam('cantidad_ex', $cantEx, PDO::PARAM_STR);
        $stmt->bindParam('observaciones', $obs, PDO::PARAM_STR);
        return $stmt->execute();
    }

    static public function mostrar($idatencion){
        $sql = "SELECT * FROM reg_atenciones WHERE idatencion = '$idatencion'";
        return Connection::executeQuery($sql);
    }

    static public function turno($turno){
        $sql = "SELECT count(r.idatencion) as cantidad FROM reg_atenciones r where r.turno = '$turno'";
        return Connection::executeQuery($sql);
    }

    static public function cantidad(){
        $sql = "SELECT count(r.idatencion) as cantidad FROM reg_atenciones r";
        return Connection::executeQuery($sql);
    }

    static public function eliminar($idatencion){
        $sql = "delete from reg_atenciones where idatencion = :idatencion";
        $link = Connection::connect();
        $stmt = $link->prepare($sql);
        $stmt->bindParam('idatencion', $idatencion, PDO::PARAM_STR);
        if($stmt->execute()){
            $response = array(
                "icono" => "success",
                "mensaje" => "Registro eliminado"
            );
            return $response;
        }else{
            $response = array(
                "icono" => "error",
                "mensaje" => "Error: no se pudo eliminar el registro"
            );
            return $response;
        }
    }

}