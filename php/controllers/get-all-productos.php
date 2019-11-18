<?php

require_once "../models/modelo.php";
require_once "../db/db.php";

// conexion a bd
$conexion = Bd::conexion();

$listaProductos = Producto::getAll($conexion);

$productosData = array();

while ($producto = $listaProductos->fetch_assoc()){
    $productosData[] = $producto;
}

echo json_encode($productosData);

$conexion->close();