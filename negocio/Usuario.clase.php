<?php

require_once '../datos/Conexion.clase.php';

class Usuario extends Conexion {
   
    public function cargarlistaDatos() {
        try {
            $sql = "select * from usuario";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();

            $resultado = $sentencia->fetchAll(PDO:: FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
}
