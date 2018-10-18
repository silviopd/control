<?php

require_once '../negocio/sesion.clase.php';
require_once '../util/funciones/Funciones.clase.php';


try {
    $email = $_POST["cbousuario"];
    $clave = $_POST["txtclave"];


    if (isset($_POST["chkrecordar"])) {
        $recordarUsuario = $_POST["chkrecordar"];
    } else {
        $recordarUsuario = "";
    }

    $objSesion = new Sesion();
    $objSesion->setLogin($email);
    $objSesion->setClave($clave);
    $objSesion->setRecordarUsuario($recordarUsuario);

    $resultado = $objSesion->iniciarSesion();
       
        switch ($resultado) {
            case 0:
                Funciones::mensaje("El usuario esta inactivo", "a", "../vista/index.php", 1.7);
                break;

            case 1:
                header("location:../vista/principal.vista.php"); 
                break;

            case 2:
                Funciones::mensaje("Seleccione un usuario", "e", "../vista/index.php", 1.7);
                break;

            default:
                break;
        }
//    }else{
//         Funciones::mensaje("captcha incorrecto", "a", "../vista/index.php", 1.7);
//    }
} catch (Exception $exc) {
    Funciones::mensaje($exc->getMessage(), "e");
}



