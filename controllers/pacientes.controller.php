<?php

require_once "../models/pacientes.model.php";

$PacientesModel = new PacientesModel();
date_default_timezone_set('America/Lima');
$idpaciente = isset($_POST['txtIdpaciente']) ? $_POST['txtIdpaciente'] : "";
$dni = isset($_POST['txtDni']) ? $_POST['txtDni'] : "";
$nombres = isset($_POST['txtNombres']) ? $_POST['txtNombres'] : "";
$apellidos = isset($_POST['txtApellidos']) ? $_POST['txtApellidos'] : "";
$fecha_reg = date('Y-m-d H:i:s');


switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idpaciente)) {
            //$rspta = $ProfesionalesModel::insertar($dni, $nombres, $apellidos, $profesion, $cmp, $fecha_reg);
            //echo $rspta ? "Profesional registrado" : "Profesional no se pudo registrar";
            echo "Accion no permitida";
        } else {
            $rspta = $PacientesModel::editar($idpaciente, $dni, $nombres, $apellidos);
            echo $rspta ? "Paciente actualizado" : "Paciente no se pudo actualizar";
        }
        break;

    case 'mostrar':
        $rspta = $PacientesModel::mostrar($idpaciente);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'cantidad':
        $rspta = $PacientesModel::cantidad();
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspt = $PacientesModel::getData();
        $data = array();
        foreach ($rspt as $result) {
            $data[] = array(
                "0" => '<button type="button" class="btn btn-sm btn-circle btn-outline-danger" onclick="mostrar(' . $result->idpaciente . ')"><i class="fa fa-gears"></i></button>
                <button type="button" class="btn btn-sm btn-circle btn-outline-primary" onclick="verRegistro(' . $result->idpaciente . ')"><i class="fa fa-eye"></i></button>',
                "1" => $result->idpaciente,
                "2" => $result->nombres . " " . $result->apellidos,
                "3" => $result->dni
            );
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($rspt),
            "iTotalDisplayRecords" => count($rspt),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'verRegistro':
        $rspt = $PacientesModel::getDataRegistro($idpaciente);
        $data = array();
        foreach ($rspt as $result) {
            $data[] = array(
                "0" => $result->fecha_atencion,
                "1" => $result->turno,
                "2" => $result->n_solicitud,
                "3" => $result->profesional,
                "4" => $result->area,
                "5" => $result->cantidad_ex,
                "6" => $result->observaciones
            );
        }
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($rspt),
            "iTotalDisplayRecords" => count($rspt),
            "aaData" => $data
        );
        echo json_encode($results);
        break;

    case 'validarDni':
        $rspta = $PacientesModel::validarDni($dni);
        $data = array();
        foreach ($rspta as $result) {
            $data[] = array(
                "0" => $result->idpaciente,
                "1" => $result->dni,
                "2" => $result->nombres,
                "3" => $result->apellidos
            );
        }
        echo empty($data) ? "1" : json_encode($data);
        break;
}
