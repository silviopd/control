<?php

require_once '../negocio/Cliente.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_codigoCliente"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objCli = new Cliente();
    $codigoCliente = $_POST["p_codigoCliente"];
    $resultado = $objCli->leerDatos($codigoCliente);
    
    Funciones::imprimeJSON(200, "", $resultado);
} catch (Exception $exc) {
    Funciones::imprimeJSON(500 ,$exc->getMessage(),"");
}


