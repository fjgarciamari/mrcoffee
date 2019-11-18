<?php
session_start();

//Comprobamos si está logueado
if(isset($_SESSION["dni"])){

    require_once "../models/modelo.php";
    require_once "../db/db.php";

    // conexion a bd
    $conexion = Bd::conexion();
    // trae lista de productos
    $listaProductos = Producto::getAll($conexion);

    include "../views/inicio.html";

    include "../views/v_cabecera.php";

    include "../views/v_listaProductos.php";

    include "../views/fin.html";

    $conexion->close();
} else {
    header("Location: http://localhost/mrcoffee/mrcoffee/html/index.html");
}

