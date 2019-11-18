<?php

class Cliente {
    private $dniCliente;
    private $nombre;
    private $direccion;
    private $email;
    private $pwd;
    private $isAdmin;

    function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    // Comprueba si el usuario y contrasenya son correctos
    public function checkPassword($conexion){
        $consulta = "SELECT * FROM clientes where dniCliente='$this->dniCliente'";

        echo password_hash($this->pwd, PASSWORD_DEFAULT);
        $resultado = $conexion->query($consulta);
        $cliente = $resultado->fetch_assoc();

        if(password_verify($this->pwd, $cliente["pwd"])) {
            return true;
        } else {
            return false;
        }
    }

    // Completa la información del cliente teniendo el dni
    public function fillClientInfo($conexion){
        $consulta = "SELECT * FROM clientes where dniCliente='$this->dniCliente'";
        $resultado = $conexion->query($consulta);
        $cliente = $resultado->fetch_assoc();

        $this->nombre = $cliente["nombre"];
        $this->direccion = $cliente["direccion"];
        $this->email = $cliente["email"];
        $this->pwd = $cliente["pwd"];
        $this->isAdmin = $cliente["isAdmin"];

    }

    public function clientExists($conexion){
        $consulta = "SELECT * FROM clientes where dniCliente='$this->dniCliente'";
        $resultado = $conexion->query($consulta);
        return $resultado;
    }

    public function guardarCliente($conexion){
        $consulta = "INSERT INTO clientes VALUES('$this->dniCliente', '$this->nombre', '$this->direccion', '$this->email', '$this->pwd', '$this->isAdmin') ";
        $resultado = $conexion->query($consulta);
        return $resultado;
    }

    public function borrarCliente($conexion){
        $consulta = "DELETE FROM clientes WHERE dniCliente = '$this->dniCliente'";
        $resultado = $conexion->query($consulta);
        return $resultado;
    }

    public function modificarCliente($conexion){
        $consulta = "UPDATE clientes SET nombre = '$this->nombre', direccion = '$this->direccion', email = '$this->email', pwd = '$this->pwd', isAdmin = '$this->isAdmin' WHERE dniCliente = '$this->dniCliente' ";
        $resultado = $conexion->query($consulta);
        return $resultado;
    }

    static function getAll ($conexion){
        $consulta = "SELECT * FROM clientes";
        $resultado = $conexion->query($consulta);
        return $resultado;
    }
}

class Producto {
    private $idProducto;
    private $nombre;
    private $origen;
    private $tipoMolido;
    private $foto;
    private $marca;
    private $peso;
    private $unidades;
    private $precio;

    function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function fillProductInfo($conexion){
        $consulta = "SELECT * FROM productos WHERE idProducto = '$this->idProducto'";
        $resultado = $conexion->query($consulta);
        $producto = $resultado->fetch_assoc();

        $this->idProducto = $producto["idProducto"];
        $this->nombre = $producto["nombre"];
        $this->origen = $producto["origen"];
        $this->tipoMolido = $producto["tipoMolido"];
        $this->foto = $producto["foto"];
        $this->marca = $producto["marca"];
        $this->peso = $producto["peso"];
        $this->unidades = $producto["unidades"];
        $this->precio = $producto["precio"];

    }

    public function guardarProducto($conexion){
        $consulta = "INSERT INTO productos (nombre, origen, tipoMolido, foto, marca, peso, unidades, precio) VALUES('$this->nombre', '$this->origen', '$this->tipoMolido', '$this->foto', '$this->marca', '$this->peso', '$this->unidades', '$this->precio') ";
        $resultado = $conexion->query($consulta);
        return $resultado;
    }

    public function borrarProducto($conexion){
        $consulta = "DELETE FROM productos WHERE idProducto = '$this->idProducto'";
        $resultado = $conexion->query($consulta);
        return $resultado;
    }

    public function modificarProducto($conexion){
        $consulta = "UPDATE producto SET nombre = '$this->nombre', origen = '$this->origen', tipoMolido = '$this->tipoMolido', marca = '$this->marca', peso = '$this->peso', unidades = '$this->unidades', precio = '$this->precio' WHERE idProducto = '$this->idProducto' ";
        $resultado = $conexion->query($consulta);
        return $resultado;
    }

    static function getAll($conexion){
        $consulta = "SELECT * FROM productos";
        $resultado = $conexion->query($consulta);
        return $resultado;
    }
}

class Pedido {
    private $idPedido;
    private $fecha;
    private $dirEntrega;
    private $nTarjeta;
    private $fechaCaducidad;
    private $matriculaRepartidor;
    private $dniCliente;
    private $lineasPedido;

    function addLineaPedido($lineaPedido){
        $this->lineasPedido[] = $lineaPedido;
    }

    function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function savePedido($conexion){
        $consulta = "INSERT INTO pedidos VALUES('$this->idPedido', CURRENT_DATE(), '$this->dirEntrega', '$this->nTarjeta', '$this->fechaCaducidad', '$this->matriculaRepartidor', '$this->dniCliente') ";
        $resultado = $conexion->query($consulta);

        for ($i=0; $i < count($this->lineasPedido); $i++) { 
            $this->lineasPedido[$i]->idPedido = $this->idPedido;
            $this->lineasPedido[$i]->nlinea = $i+1;
            $this->lineasPedido[$i]->saveLineaPedido($conexion);
        }

        return $resultado;
    }

    public function insertPedido($conexion){
        $consulta = "INSERT INTO pedidos VALUES('$this->idPedido', '$this->fecha', '$this->dirEntrega', '$this->nTarjeta', '$this->fechaCaducidad', '$this->matriculaRepartidor', '$this->dniCliente') ";
        $resultado = $conexion->query($consulta);

        return $resultado;
    }

    public function borrarPedido($conexion){
        $consulta = "DELETE FROM pedidos WHERE idPedido = '$this->idPedido'";
        $resultado = $conexion->query($consulta);
        
        return $resultado;
        
    }

    public function modificarPedido($conexion){
        $consulta = "UPDATE pedidos SET nombre = '$this->nombre', origen = '$this->origen', tipoMolido = '$this->tipoMolido', foto = '$this->foto', marca = '$this->marca', peso = '$this->peso', unidades = '$this->unidades', precio = '$this->precio' WHERE idProducto = '$this->idProducto' ";
        $resultado = $conexion->query($consulta);
        return $resultado;
    }

    static function getAll($conexion){
        $consulta = "SELECT * FROM pedidos";
        $resultado = $conexion->query($consulta);
        return $resultado;
    }

    static function getNextId($conexion){
        $consulta = "SELECT MAX(idPedido) as idPedido FROM pedidos";
        $resultado = $conexion->query($consulta);
        $nextId = $resultado->fetch_assoc();
        return $nextId["idPedido"]+1;
    }
}

class LineaPedido {
    private $idPedido;
    private $nlinea;
    private $idProducto;
    private $cantidad;

    function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function saveLineaPedido($conexion){
        $consulta = "INSERT INTO lineaspedidos VALUES('$this->idPedido', '$this->nlinea', '$this->idProducto', '$this->cantidad') ";
        $resultado = $conexion->query($consulta);
    }

    public function borrarLineaPedido($conexion){
        $consulta = "DELETE FROM lineaspedidos WHERE idPedido = '$this->idPedido' AND nlinea = '$this->nlinea'";
        $resultado = $conexion->query($consulta);
        return $resultado;
    }

    static function getAllLinesByIdPedido($conexion, $idPedido){
        $consulta = "SELECT * FROM lineaspedidos WHERE idPedido = '$idPedido' ";
        $resultado = $conexion->query($consulta);
        return $resultado;
    }

}

class CarritoUtilidades {
    //Recibe por parametros la linea de compra y la añade al carrito
    static function addLineaCompra($idProducto, $nombre, $precio/*, $foto*/, $cantidad){
        $_SESSION["carrito"]["idProducto"][$_SESSION["total"]]= $idProducto;
        $_SESSION["carrito"]["nombre"][$_SESSION["total"]]= $nombre;
        $_SESSION["carrito"]["precio"][$_SESSION["total"]]= $precio;
        //$_SESSION["carrito"]["foto"][$_SESSION["total"]]= $foto;
        $_SESSION["carrito"]["cantidad"][$_SESSION["total"]]= $cantidad;

        $_SESSION["total"] = $_SESSION["total"]+1;

    }
    //Recibe por parametro un array con las cantidades
    static function actualizaCantidades($cantidades){
        for ($i=0; $i < count($cantidades); $i++) { 
            $_SESSION["carrito"]["cantidad"][$i]= $cantidades[$i];
        }
    }

}