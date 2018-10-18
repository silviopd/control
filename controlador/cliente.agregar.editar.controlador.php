<?php

require_once '../negocio/Cliente.clase.php';
require_once '../util/funciones/Funciones.clase.php';

//duplicidad here :v
if (! isset($_POST["p_datosFormulario"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$datosFormulario = $_POST["p_datosFormulario"];

//Convertir todos los datos que llegan concatenados a un array
parse_str($datosFormulario, $datosFormularioArray);



//quitar
print_r($datosFormularioArray);
exit();

try {
    $objCliente = new Cliente();
    $objCliente->setApellidos( $datosFormularioArray["txtapellidos"] );
    $objCliente->setNombres( $datosFormularioArray["txtnombres"] );
    $objCliente->setEmail( $datosFormularioArray["txtemail"] );
    $objCliente->setSexo( $datosFormularioArray["cbosexomodal"] );
    $objCliente->setVip( $datosFormularioArray["cbovipmodal"] );
    $objCliente->setCodigo_ciudad( $datosFormularioArray["cbociudadmodal"] );
    $objCliente->setCodigo_usuario( $datosFormularioArray["cbousuariomodal"] );
    
    if ($datosFormularioArray["txttipooperacion"]=="agregar"){
        $resultado = $objCliente->agregar();
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }else{
        $objCliente->setCodigo_cliente($datosFormularioArray["txtcodigo"]);
        $resultado = $objCliente->editar($objCliente);
        if ($resultado==true){
            Funciones::imprimeJSON(200, "Grabado correctamente", "");
        }
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
