<?php
require_once '../datos/Conexion.clase.php';

class Pais extends Conexion{
    
    public function cargarListaDatos() {
        try {
            $sql = "select * from pais order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();

            $resultado = $sentencia->fetchall(PDO::FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
}
