<?php

require_once '../datos/Conexion.clase.php';

class Cliente extends Conexion {

    private $codigo_cliente;
    private $apellidos;
    private $nombres;
    private $email;
    private $sexo;
    private $vip;
    private $codigo_ciudad;
    private $codigo_usuario;

    function getCodigo_cliente() {
        return $this->codigo_cliente;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getEmail() {
        return $this->email;
    }

    function getSexo() {
        return $this->sexo;
    }

    function getVip() {
        return $this->vip;
    }

    function getCodigo_ciudad() {
        return $this->codigo_ciudad;
    }

    function getCodigo_usuario() {
        return $this->codigo_usuario;
    }

    function setCodigo_cliente($codigo_cliente) {
        $this->codigo_cliente = $codigo_cliente;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    function setVip($vip) {
        $this->vip = $vip;
    }

    function setCodigo_ciudad($codigo_ciudad) {
        $this->codigo_ciudad = $codigo_ciudad;
    }

    function setCodigo_usuario($codigo_usuario) {
        $this->codigo_usuario = $codigo_usuario;
    }

    public function listar($p_codigoPais, $p_codigoCiudad, $p_codigoUsuario) {
        try {
//            $sql = "select * from f_listar_cliente(:p_codigoPais,:p_codigoCiudad,:p_codigoUsuario)";
            $sql = "select * from f_listar_clientes(:p_codigoPais,:p_codigoCiudad,:p_codigoUsuario)";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigoPais", $p_codigoPais);
            $sentencia->bindParam(":p_codigoCiudad", $p_codigoCiudad);
            $sentencia->bindParam(":p_codigoUsuario", $p_codigoUsuario);
            $sentencia->execute();

            $resultado = $sentencia->fetchAll(PDO:: FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }

    public function eliminar($p_CodigoCliente) {
        $this->dblink->beginTransaction();
        try {
            $sql = "delete from cliente where codigo_cliente=:p_codigoCliente";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigoCliente", $p_CodigoCliente);
            $sentencia->execute();

            $this->dblink->commit();
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            throw $exc;
        }

        return false;
    }

    public function agregar() {
        $this->dblink->beginTransaction();

        try {
            $sql = "select * from f_generar_correlativo('cliente') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();

            if ($sentencia->rowCount()) {
                $nuevoCodigoCliente = $resultado["nc"];
                $this->setCodigo_cliente($nuevoCodigoCliente);

                $sql = "INSERT INTO cliente(codigo_cliente, apellidos, nombres, email, sexo, vip, codigo_ciudad,codigo_usuario) 
                        VALUES (:p_codigo_cliente,:p_apellidos,:p_nombres,:p_email, :p_sexo,:p_vip, :p_codigo_ciudad,:p_codigo_usuario);";

                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);

                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_codigo_cliente", $this->getCodigo_cliente());
                $sentencia->bindParam(":p_apellidos", $this->getApellidos());
                $sentencia->bindParam(":p_nombres", $this->getNombres());
                $sentencia->bindParam(":p_email", $this->getEmail());
                $sentencia->bindParam(":p_sexo", $this->getSexo());
                $sentencia->bindParam(":p_vip", $this->getVip());
                $sentencia->bindParam(":p_codigo_ciudad", $this->getCodigo_ciudad());
                $sentencia->bindParam(":p_codigo_usuario", $this->getCodigo_usuario());

                //Ejecutar la sentencia preparada
                $sentencia->execute();


                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'cliente'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();

                $this->dblink->commit();

                return true; //significa que todo se ha ejecutado correctamente
            } else {
                throw new Exception("No se ha configurado el correlativo para la tabla artículo");
            }
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }

        return false;
    }

    public function leerDatos($p_codigoCliente) {
        try {
            $sql = "SELECT 
  cliente.codigo_cliente, 
  cliente.apellidos, 
  cliente.nombres, 
  cliente.email, 
  cliente.sexo, 
  cliente.vip, 
  cliente.codigo_ciudad, 
  pais.codigo_pais, 
  cliente.codigo_usuario
  FROM 
  public.cliente, 
  public.ciudad, 
  public.pais, 
  public.usuario
  WHERE 
  cliente.codigo_ciudad = ciudad.codigo_ciudad AND
  cliente.codigo_usuario = usuario.codigo_usuario AND
  ciudad.codigo_pais = pais.codigo_pais AND
  cliente.codigo_cliente=:p_codigo_cliente;
";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_codigo_cliente", $p_codigoCliente);
            $sentencia->execute();

            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function editar() {
        $this->dblink->beginTransaction();

        try {
            $sql = "UPDATE cliente 
   SET apellidos=:p_apellidos, nombres=:p_nombres, email=:p_email, sexo=:p_sexo, vip=:p_vip, 
       codigo_ciudad=:p_codigo_ciudad, codigo_usuario=:p_codigo_usuario
 WHERE codigo_cliente=:p_codigo_cliente;
";
            $sentencia = $this->dblink->prepare($sql);
            //Asignar un valor a cada parametro
            $sentencia->bindParam(":p_apellidos", $this->getApellidos());
            $sentencia->bindParam(":p_nombres", $this->getNombres());
            $sentencia->bindParam(":p_email", $this->getEmail());
            $sentencia->bindParam(":p_sexo", $this->getSexo());
            $sentencia->bindParam(":p_vip", $this->getVip());
            $sentencia->bindParam(":p_codigo_ciudad", $this->getCodigo_ciudad());
            $sentencia->bindParam(":p_codigo_usuario", $this->getCodigo_usuario());
            $sentencia->bindParam(":p_codigo_cliente", $this->getCodigo_cliente());

            //Ejecutar la sentencia preparada
            $sentencia->execute();

            $this->dblink->commit();
            return true;
        } catch (Exception $exc) {
            $this->dblink->rollBack();
            echo $exc->getTraceAsString();
        }
        return false;
    }

}
