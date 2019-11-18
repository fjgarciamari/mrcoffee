<?php

session_start();

//Comprobamos si está logueado
if(isset($_SESSION["dni"])){


    require_once "../models/modelo.php";
    require_once "../db/db.php";

    // conexion a bd
    $conexion = Bd::conexion();

    $producto = new Producto;
    $producto->idProducto = $_GET["idProducto"];

    include "../views/inicio.html";

    include "../views/v_cabecera.php";

    $producto->fillProductInfo($conexion);

    if($producto->nombre != ""){
        include "../views/v_detalle-producto.php";
    } else {
        include "../views/v_no-producto.php";
    }

    include "../views/fin.html";

    $conexion->close();
} else {
    header("Location: http://localhost/mrcoffee/mrcoffee/html/index.html");
}