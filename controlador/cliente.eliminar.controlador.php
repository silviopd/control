<?php

require_once '../negocio/Cliente.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (!isset($_POST["codigoCliente"])) {
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

try {
    $objArt = new Cliente();
    $codigoCliente = $_POST["codigoCliente"];
    $resultado = $objArt->eliminar($codigoCliente);
    if ($resultado == true) {
        //elimino correctamente
        Funciones::imprimeJSON(200, "Se ha eliminado el registro satisfactoriamente", "");
    } else {
        Funciones::imprimeJSON(500, $exc->getMessage(), "");
    }
} catch (Exception $exc) {
    echo $exc->getTraceAsString();
}

