<?php 
session_start();

//Comprobamos si está logueado
if(isset($_SESSION["dni"])){

    require_once "../models/modelo.php";


    if(isset($_POST["comprar"])){

        // Aplicamos la compra al carrito
        CarritoUtilidades::addLineaCompra($_POST["idProducto"],$_POST["nombre"],$_POST["precio"],$_POST["cantidad"]);

        include "../views/inicio.html";
        include "../views/v_cabecera.php";
        
        muestraCarrito();

    } else if (isset($_POST["actualizarCantidades"]) && isset($_POST["cantidad"])){
        
        CarritoUtilidades::actualizaCantidades($_POST["cantidad"]);

        include "../views/inicio.html";
        include "../views/v_cabecera.php";
        
        muestraCarrito();
    } else {
        include "../views/inicio.html";
        include "../views/v_cabecera.php";

        muestraCarrito();
    }
    } else {
        header("Location: http://localhost/mrcoffee/mrcoffee/html/index.html");
    }


function muestraCarrito(){
    if ($_SESSION["total"] > 0){
        include "../views/v_muestracarrito.php";
    }else{
        // TODO: Modificar esto para mostrar vista
        echo "No hay productos en el carrito";
    }
}

