<?php

require_once "../models/atencion.model.php";
require_once "../models/pacientes.model.php";

$AtencionModel = new AtencionModel();
$PacientesModel = new PacientesModel();
date_default_timezone_set('America/Lima');
$idpaciente = isset($_POST['txtIdpaciente']) ? $_POST['txtIdpaciente'] : "";
$idatencion = isset($_POST['txtIdatencion']) ? $_POST['txtIdatencion'] : "";
$dni = isset($_POST['txtDni']) ? $_POST['txtDni'] : "";
$nombres = isset($_POST['txtNombres']) ? $_POST['txtNombres'] : "";
$apellidos = isset($_POST['txtApellidos']) ? $_POST['txtApellidos'] : "";
$fecha_atencion = isset($_POST['txtFecAte']) ? $_POST['txtFecAte'] : "";
$turno = isset($_POST['txtTurno']) ? $_POST['txtTurno'] : "";
$nun_sol = isset($_POST['txtNunSol']) ? $_POST['txtNunSol'] : "";
$area = isset($_POST['txtArea']) ? $_POST['txtArea'] : "";
$cant_Ex = isset($_POST['txtCantExa']) ? $_POST['txtCantExa'] : "";
$idprofesional = isset($_POST['txtProfesional']) ? $_POST['txtProfesional'] : "";
$obs = isset($_POST['txtObservaciones']) ? $_POST['txtObservaciones'] : "";
$fecha_reg = date('Y-m-d H:i:s');
$hora_atencion = date('H:i:s');
$fecha_hora_atencion = $fecha_atencion . ' ' . $hora_atencion;
$dateFormat = date_format(date_create($fecha_atencion), 'Y-m-d H:i:s');
$idprof = isset($_POST['idprof']) ? $_POST['idprof'] : "";
$desde = isset($_POST['desde']) ? $_POST['desde'] : "";
$hasta = isset($_POST['hasta']) ? $_POST['hasta'] : "";
$desdeF = date_format(date_create($desde), 'Y-m-d');
$hastaF = date_format(date_create($hasta), 'Y-m-d');

switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idatencion)) {
            if (empty($idpaciente)) {
                $rspta = $PacientesModel::insertar($dni, $nombres, $apellidos, $fecha_reg);
                if ($rspta != "error") {
                    $rspta2 = $AtencionModel::insertar($dateFormat, $turno, $nun_sol, $idprofesional, $area, $cant_Ex, $obs, $fecha_reg, $rspta);
                    echo $rspta2 ? "Se registro correctamente" : "No se pudo registrar";
                } else {
                    echo "No se pudo registrar al paciente";
                }
            } else {
                $rspta2 = $AtencionModel::insertar($dateFormat, $turno, $nun_sol, $idprofesional, $area, $cant_Ex, $obs, $fecha_reg, $idpaciente);
                echo $rspta2 ? "Se registro correctamente" : "No se pudo registrar";
            }
        } else {
            $rspta = $AtencionModel::editar($idatencion, $dateFormat, $turno, $nun_sol, $idprofesional, $area, $cant_Ex, $obs, $fecha_reg, $idpaciente);
            echo $rspta ? "Registro actualizado" : "No se pudo actualizar";
        }
        break;

    case 'mostrar':
        $rspta = $AtencionModel::mostrar($idatencion);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'turno':
        $rspta = $AtencionModel::turno($turno);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'cantidad':
        $rspta = $AtencionModel::cantidad();
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'eliminar':
        $rspta = $AtencionModel::eliminar($idatencion);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspt = $AtencionModel::getData();
        $data = array();
        foreach ($rspt as $result) {
            $data[] = array(
                "0" => '<button type="button" class="btn btn-sm btn-circle btn-outline-warning" onclick="mostrar(' . $result->idatencion . ')"><i class="fa fa-gears"></i></button>
                <button type="button" class="btn btn-sm btn-circle btn-outline-danger" onclick="eliminar(' . $result->idatencion . ')"><i class="fa fa-trash-o"></i></button>',
                "1" => $result->idatencion,
                "2" => $result->profesional,
                "3" => $result->area,
                "4" => $result->turno,
                "5" => $result->n_solicitud,
                "6" => $result->observaciones,
                "7" => $result->fecha_atencion,
                "8" => $result->paciente,
                "9" => $result->fecha_reg
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

    case 'filtrar':
        $rspt = $AtencionModel::getDataFilter($idprof, $desdeF, $hastaF);
        $data = array();
        foreach ($rspt as $result) {
            $data[] = array(
                "0" => '<button type="button" class="btn btn-sm btn-circle btn-outline-warning" onclick="mostrar(' . $result->idatencion . ')"><i class="fa fa-gears"></i></button>
                    <button type="button" class="btn btn-sm btn-circle btn-outline-danger" onclick="eliminar(' . $result->idatencion . ')"><i class="fa fa-trash-o"></i></button>',
                "1" => $result->idatencion,
                "2" => $result->profesional,
                "3" => $result->area,
                "4" => $result->turno,
                "5" => $result->n_solicitud,
                "6" => $result->observaciones,
                "7" => $result->fecha_atencion,
                "8" => $result->paciente,
                "9" => $result->fecha_reg
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
}
