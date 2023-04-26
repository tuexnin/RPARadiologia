<?php

require_once "../models/usuarios.model.php";

$UsuariosModel = new UsuariosModel();
date_default_timezone_set('America/Lima');
$idusuario = isset($_POST['txtIdusuario']) ? $_POST['txtIdusuario'] : "";
$nombres = isset($_POST['txtNombres']) ? $_POST['txtNombres'] : "";
$apellidos = isset($_POST['txtApellidos']) ? $_POST['txtApellidos'] : "";
$dni = isset($_POST['txtDni']) ? $_POST['txtDni'] : "";
$email = isset($_POST['txtEmail']) ? $_POST['txtEmail'] : "";
$usuario = isset($_POST['txtUsuario']) ? $_POST['txtUsuario'] : "";
$clave = isset($_POST['txtPassword']) ? $_POST['txtPassword'] : "";
$celular = isset($_POST['txtCelular']) ? $_POST['txtCelular'] : "";
$fecha_reg = date('Y-m-d H:i:s');
$contraseña = isset($_POST['txtContraseña']) ? $_POST['txtContraseña'] : "";
$imagen = isset($_POST['txtImagen']) ? $_POST['txtImagen'] : "";
$rol = isset($_POST['txtRol']) ? $_POST['txtRol'] : "";



switch ($_GET["op"]) {
    case 'guardaryeditar':
        if (!file_exists($_FILES['txtImagen']['tmp_name']) || !is_uploaded_file($_FILES['txtImagen']['tmp_name'])) {
            $imagen = $_POST["imagenactual"];
        } else {
            $ext = explode(".", $_FILES["txtImagen"]["name"]);
            if ($_FILES['txtImagen']['type'] == "image/jpg" || $_FILES['txtImagen']['type'] == "image/jpeg" || $_FILES['txtImagen']['type'] == "image/png") {
                $imagen = round(microtime(true)) . '.' . end($ext);
                move_uploaded_file($_FILES["txtImagen"]["tmp_name"], "../files/fotos/" . $imagen);
                if(!empty($_POST["imagenactual"])){
                    unlink('../files/fotos/' . $_POST["imagenactual"]);
                }
            }
        }
        $password = hash('md5', $clave);
        if (empty($idusuario)) {
            $rspta = $UsuariosModel::insertar($dni, $nombres, $apellidos, $celular, $email, $usuario, $password, $fecha_reg, $imagen, $rol);
            echo $rspta ? "Usuario registrado" : "Usuario no se pudo registrar";
        } else {
            if (!empty($clave)) {
                $rspta = $UsuariosModel::editar($idusuario, $dni, $nombres, $apellidos, $celular, $email, $usuario, $password, $imagen, $rol);
            } else {
                $rspta = $UsuariosModel::editar($idusuario, $dni, $nombres, $apellidos, $celular, $email, $usuario, $contraseña, $imagen, $rol);
            }
            echo $rspta ? "Usuario actualizada" : "Usuario no se pudo actualizar";
        }
        break;

    case 'mostrar':
        $rspta = $UsuariosModel::mostrar($idusuario);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'eliminar':
        $rspta = $UsuariosModel::mostrar($idusuario);
        foreach ($rspta as $result) {
            if(!empty($result->foto)){
                unlink('../files/fotos/' . $result->foto);
            }
        }
        $rspta = $UsuariosModel::eliminar($idusuario);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'listar':
        $rspt = $UsuariosModel::getData();
        $data = array();
        foreach ($rspt as $result) {
            $data[] = array(
                "0" => '<button type="button" class="btn btn-sm btn-circle btn-outline-warning" onclick="mostrar(' . $result->idusuario . ')"><i class="fa fa-gears"></i></button>
                <button type="button" class="btn btn-sm btn-circle btn-outline-danger" onclick="eliminar(' . $result->idusuario . ')"><i class="fa fa-trash-o"></i></button>',
                "1" => $result->nombres . " " . $result->apellidos,
                "2" => $result->dni,
                "3" => empty($result->foto) ? "<img src='pages/assets/img/avatars/avatar15.jpg' height='50px' width='50px' >" : "<img src='files/fotos/".$result->foto."' height='50px' width='50px' >",
                "4" => $result->usuario,
                "5" => $result->rol
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
