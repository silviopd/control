<?php

require_once '../negocio/Cliente.clase.php';
require_once '../util/funciones/Funciones.clase.php';

try {
    
//    if (!isset($_POST["codigoCiudad"])) {
//        Funciones::imprimeJSON(500, "Faltan Parametros", "");
//        exit;
//    }
    
    $codigoPais = $_POST["codigoPais"];
    $codigoCiudad = $_POST["codigoCiudad"];
    $codigoUsuario = $_POST["codigoUsuario"];
    
    $objCliente = new Cliente();
    $resultado = $objCliente->listar($codigoPais,$codigoCiudad, $codigoUsuario);    
    
    Funciones::imprimeJSON(200, "", $resultado);
    
   
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}


