<?php

require_once "../models/modelo.php";
require_once "../db/db.php";

// conexion a bd
$conexion = Bd::conexion();

$producto = new Producto;

$producto->idProducto = $_POST["idProducto"];

$producto->borrarProducto($conexion);

$conexion->close();

echo $producto->idProducto." se ha eliminado";