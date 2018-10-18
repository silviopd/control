<?php

require '../datos/Conexion.clase.php';

class Sesion extends Conexion {

    private $login;
    private $clave;
    private $recordarUsuario;

    function getLogin() {
        return $this->login;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function getClave() {
        return $this->clave;
    }

    function getRecordarUsuario() {
        return $this->recordarUsuario;
    }


    function setClave($clave) {
        $this->clave = $clave;
    }

    function setRecordarUsuario($recordarUsuario) {
        $this->recordarUsuario = $recordarUsuario;
    }

    public function iniciarSesion() {
        try {
            $sql = "select * from usuario where login=:p_login";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_login", $this->getLogin());
            $sentencia->execute();
            $resultado = $sentencia->fetch();

            if ($resultado["contrasena"] == md5($this->getClave())) {
                if ($resultado["situacion"] == "0") {
                    return 0;
                } else {
                    session_name("SitemaComercial1");
                    session_start();

                    $_SESSION["s_nombre_usuario"] = $resultado["apellido_paterno"] . " " . $resultado["apellido_materno"] . " " . $resultado["nombres"];
                    $_SESSION["s_cargo_usuario"] = $resultado["cargo"];
                    $_SESSION["s_codigo_usuario"] = $resultado["codigo_usuario"];

                    if ($this->getRecordarUsuario() == "S") {
                        setcookie("loginusuario", $this->getLogin(), 0, "/");
                    } else {
                        setcookie("loginusuario", "", 0, "/");
                    }
                    return 1;
                }
            } else {
                return 2;
            }
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    
}
