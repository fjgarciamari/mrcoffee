<?php


require_once "../models/modelo.php";
require_once "../db/db.php";

// conexion a bd
$conexion = Bd::conexion();

$pedido = new Pedido;

$pedido->idPedido = $_POST["idPedido"];

$error = false;

// Si se ha borrado el pedido nos disponemos a borrar todas las lineas de pedido asociadas
if($pedido->borrarPedido($conexion)){
    $lineasPedidoAsociadas = LineaPedido::getAllLinesByIdPedido($conexion, $pedido->idPedido);

    while($lineaPedidoAssoc = $lineasPedidoAsociadas->fetch_assoc()){
        $lineaPedido = new LineaPedido;
        $lineaPedido->idPedido = $lineaPedidoAssoc["idPedido"];
        $lineaPedido->nlinea = $lineaPedidoAssoc["nlinea"];
        if(!$lineaPedido->borrarLineaPedido($conexion)){
            $error = true;
        }
    }
}else {
    $error = true;
}

$conexion->close();

$response = array('error' => $error);
echo json_encode($response);