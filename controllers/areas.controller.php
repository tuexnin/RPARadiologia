<?php

require_once "../models/areas.model.php";

$AreasModel = new AreasModel();
date_default_timezone_set('America/Lima');
$idarea = isset($_POST['txtIdarea']) ? $_POST['txtIdarea'] : "";
$nombre = isset($_POST['txtNombre']) ? $_POST['txtNombre'] : "";
$fecha_reg = date('Y-m-d H:i:s');


switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (empty($idarea)) {
            $rspta = $AreasModel::insertar($nombre, $fecha_reg);
            echo $rspta ? "Area registrada" : "Area no se pudo registrar";
        } else {
            $rspta = $AreasModel::editar($idarea, $nombre);
            echo $rspta ? "Area actualizada" : "Area no se pudo actualizar";
        }
        break;

    case 'mostrar':
        $rspta = $AreasModel::mostrar($idarea);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspt = $AreasModel::getData();
        $data = array();
        foreach ($rspt as $result) {
            $data[] = array(
                "0" => '<button type="button" class="btn btn-sm btn-circle btn-outline-danger" onclick="mostrar(' . $result->idarea . ')"><i class="fa fa-gears"></i></button>',
                "1" => $result->nombre,
                "2" => $result->estado ? '<a class="badge badge-danger" href="#" onclick="activar(' . $result->idarea . ')">Inactivo</a>' : '<a class="badge badge-success" href="#" onclick="desactivar(' . $result->idarea . ')">Activo</a>'
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

    case 'selectArea':
        $rspt = $AreasModel::getSelectArea();
        echo "<option value=''>Seleccione</option>";
        foreach ($rspt as $result) {
            echo "<option value='$result->idarea'>$result->nombre</option>";
        }
        break;

    case 'cantidad':
        $rspta = $AreasModel::cantidad();
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'activar':
        $rspta = $AreasModel::estado($idarea, 0);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'desactivar':
        $rspta = $AreasModel::estado($idarea, 1);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
}
