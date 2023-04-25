<?php

require_once "../models/profesionales.model.php";

$ProfesionalesModel = new ProfesionalesModel();
date_default_timezone_set('America/Lima');
$idprofesional = isset($_POST['txtIdprofesional']) ? $_POST['txtIdprofesional'] : "";
$dni = isset($_POST['txtDni']) ? $_POST['txtDni'] : "";
$nombres = isset($_POST['txtNombres']) ? $_POST['txtNombres'] : "";
$apellidos = isset($_POST['txtApellidos']) ? $_POST['txtApellidos'] : "";
$profesion = isset($_POST['txtProfesion']) ? $_POST['txtProfesion'] : "";
$cmp = isset($_POST['txtCmp']) ? $_POST['txtCmp'] : "";
$fecha_reg = date('Y-m-d H:i:s');


switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idprofesional)) {
            $rspta = $ProfesionalesModel::insertar($dni, $nombres, $apellidos, $profesion, $cmp, $fecha_reg);
            echo $rspta ? "Profesional registrado" : "Profesional no se pudo registrar";
        } else {
            $rspta = $ProfesionalesModel::editar($idprofesional, $dni, $nombres, $apellidos, $profesion, $cmp);
            echo $rspta ? "Profesional actualizado" : "Profesional no se pudo actualizar";
        }
        break;

    case 'mostrar':
        $rspta = $ProfesionalesModel::mostrar($idprofesional);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspt = $ProfesionalesModel::getData();
        $data = array();
        foreach ($rspt as $result) {
            $data[] = array(
                "0" => '<button type="button" class="btn btn-sm btn-circle btn-outline-danger" onclick="mostrar(' . $result->idprofesional . ')"><i class="fa fa-gears"></i></button>
                <button type="button" class="btn btn-sm btn-circle btn-outline-primary" onclick="verRegistro(' . $result->idprofesional . ')"><i class="fa fa-eye"></i></button>',
                "1" => $result->nombres . " " . $result->apellidos,
                "2" => $result->dni,
                "3" => $result->profesion,
                "4" => $result->cmp,
                "5" => $result->estado ? '<a class="badge badge-danger" href="#" onclick="activar(' . $result->idprofesional . ')">Inactivo</a>' : '<a class="badge badge-success" href="#" onclick="desactivar(' . $result->idprofesional . ')">Activo</a>'
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
        $rspt = $ProfesionalesModel::getDataRegistro($idprofesional);
        $data = array();
        foreach ($rspt as $result) {
            $data[] = array(
                "0" => $result->pasiente,
                "1" => $result->fecha_atencion,
                "2" => $result->turno,
                "3" => $result->n_solicitud,
                "4" => $result->area,
                "5" => $result->cantidad_ex,
                "6" => $result->observaciones,
                "7" => $result->fecha_reg
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

    case 'selectProfesional':
        $rspt = $ProfesionalesModel::getSelectProfesional();
        echo "<option value=''>Seleccione</option>";
        foreach ($rspt as $result) {
            echo "<option value='$result->idprofesional'>$result->profesional</option>";
        }
        break;

    case 'cantidad':
        $rspta = $ProfesionalesModel::cantidad();
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'activar':
        $rspta = $ProfesionalesModel::estado($idprofesional, 0);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'desactivar':
        $rspta = $ProfesionalesModel::estado($idprofesional, 1);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
}
