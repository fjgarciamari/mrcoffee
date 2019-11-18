<?php

//GET Para entregar PHP antes cambiar a POST

require_once "../models/modelo.php";
require_once "../db/db.php";

// conexion a bd
$conexion = Bd::conexion();

$producto = new Producto;

$producto->idProducto = $_POST["idProducto"];
$producto->nombre = $_POST["nombre"];
$producto->origen = $_POST["origen"];
$producto->tipoMolido = $_POST["tipoMolido"];
$producto->marca = $_POST["marca"];
$producto->peso = $_POST["peso"];
$producto->unidades = $_POST["unidades"];
$producto->precio = $_POST["precio"];


if($producto->modificarProducto($conexion)){
    echo json_encode($producto->idProducto);
} else {
    $error = true;
    echo json_encode($error);
};

$conexion->close();

