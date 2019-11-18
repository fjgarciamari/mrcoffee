<?php

require_once "../models/modelo.php";
require_once "../db/db.php";

// conexion a bd
$conexion = Bd::conexion();

$pedido = new Pedido;

$pedido->idPedido = Pedido::getNextId($conexion);
$pedido->fecha = $_POST["fecha"];
$pedido->dirEntrega = $_POST["dirEntrega"];
$pedido->nTarjeta = $_POST["nTarjeta"];
$pedido->fechaCaducidad = $_POST["fechaCaducidad"];
$pedido->matriculaRepartidor = $_POST["matriculaRepartidor"];
$pedido->dniCliente = $_POST["dniCliente"];

if($pedido->insertPedido($conexion)){
    $arrayResult = array("idPedido" => $pedido->idPedido);
    echo json_encode($arrayResult);
} else {
    $arrayResult = array("error" => true);
    echo json_encode($arrayResult);
};




