<?php

require_once "../models/modelo.php";
require_once "../db/db.php";

// conexion a bd
$conexion = Bd::conexion();

$listaPedidos = Pedido::getAll($conexion);

$pedidosData = array();

while ($pedido = $listaPedidos->fetch_assoc()){
    $pedidosData[] = $pedido;
}

echo json_encode($pedidosData);

$conexion->close();