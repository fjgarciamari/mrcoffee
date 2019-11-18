<?php

    $pedidoContenido = "<div class='pedido-finalizado'>";
    $totalPedido = 0;
    $totalCantidad = 0;

    for ($i=0; $i < count($pedido->lineasPedido); $i++) { 

        $pedidoContenido .= "<div class='pedido-finalizado__lineaPedido'>".$pedido->lineasPedido[$i]->nlinea."</div>";
        $producto = new Producto;
        $producto->idProducto = $pedido->lineasPedido[$i]->idProducto;
        $producto->fillProductInfo($conexion);
        $pedidoContenido .= "<div class='pedido-finalizado__nombreProducto'>$producto->nombre</div>";
        $pedidoContenido .= "<div class='pedido-finalizado__cantidad'>".$pedido->lineasPedido[$i]->cantidad."</div>";
        $pedidoContenido .= "<div class='pedido-finalizado__precioUnitario'>$producto->precio</div>";
        $precioCalculado = $producto->precio*$pedido->lineasPedido[$i]->cantidad;
        $pedidoContenido .= "<div class='pedido-finalizado__precioTotal'>".$precioCalculado."</div>";
        
        $totalPedido = $totalPedido + $precioCalculado;
        $totalCantidad += $pedido->lineasPedido[$i]->cantidad;

    }

    $pedidoContenido .= "<div class='pedido-finalizado__totalCantidad'> Cantidad (".$totalCantidad.")</div>";

    $pedidoContenido .= "<div class='pedido-finalizado__totalPedido'> Total ".$totalPedido." € </div>";

    $pedidoContenido .= "</div>";

    echo $pedidoContenido;


?>