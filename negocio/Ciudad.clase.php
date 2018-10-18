<?php
require_once '../datos/Conexion.clase.php';
class Ciudad extends Conexion{
    //put your code here
    public function cargarListaDatos($p_codigoPais){
	try {
            $sql = " select * from ciudad where codigo_pais=:p_codigoPais order by 2";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia -> bindParam(":p_codigoPais",$p_codigoPais);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
}
