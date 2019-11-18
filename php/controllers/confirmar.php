<?php
session_start();

//Comprobamos si está logueado
if(isset($_SESSION["dni"])){

    require_once "../models/modelo.php";
    require_once "../db/db.php";

    // conexion a bd
    $conexion = Bd::conexion();

    $nextId = Pedido::getNextId($conexion);

    $pedido = new Pedido();

    $pedido->idPedido = $nextId;
    $pedido->dniCliente = $_SESSION['dni'];
    $pedido->lineasPedido = array();

    // Paso las lineas de pedido a un array dentro de Pedido
    for ($i=0; $i < $_SESSION["total"]; $i++) { 
        if ($_SESSION["carrito"]["cantidad"][$i] > 0){
            $lineaPedido = new LineaPedido();

            $lineaPedido->idProducto = $_SESSION["carrito"]["idProducto"][$i];
            $lineaPedido->cantidad = $_SESSION["carrito"]["cantidad"][$i];

            $pedido->addLineaPedido($lineaPedido);
        }
        
    }

    $pedido->savePedido($conexion);

    include "../views/v_muestra-pedido-finalizado.php";


    session_destroy();

    $conexion->close();

    include "../views/fin.html";
} else {
    header("Location: http://localhost/mrcoffee/mrcoffee/html/index.html");
}