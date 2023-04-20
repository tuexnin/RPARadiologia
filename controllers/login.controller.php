<?php

require_once "../models/login.model.php";

$LoginModel = new LoginModel();


switch ($_GET["op"]) {
    case 'validar':
            $rspta = $LoginModel::getUser($_POST['login-username']);
            $datos = array();
            if (!empty($rspta)){
                foreach ($rspta as $result) {
                    if(hash('md5', $_POST['login-password']) == $result->password){
                        $datos[] = array(
                            "0" => $result->idusuario,
                            "1" => $result->nombres . " " . $result->apellidos,
                            "2" => $result->usuario,
                            "3" => $result->dni,
                            "4" => $result->celular
                        );
                    }else{
                        $datos[] = array(
                            "0" => 'no password',
                            "1" => $result->nombres . " " . $result->apellidos
                        );
                    }
                }
                echo json_encode($datos);
            }else{
                echo '0';
            }
        break;
    
    case 'iniciar':
        session_start();
        $_SESSION['idusuario'] = $_POST['idusuario'];
        $_SESSION['usuario'] = $_POST['usuario'];
        $_SESSION['nombres'] = $_POST['nombres'];
        $_SESSION['dni'] = $_POST['dni'];
        break;

    case 'cerrar':
        session_start();
        session_destroy();
        echo 'se cerro';
        break;
}