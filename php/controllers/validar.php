<?php

/* Aqui llamará el login para verificar la contraseña 
y si el usuario es administrador en principio llegarán
2 parametros dniCliente y pwd esa contraseña se enfrentará
con la de la bbdd y si es correcto comprobará si es administrador
en caso afirmativo enviará a el panel de administrador 
en caso negativo enviará a principal.php*/



if (isset($_POST["login"])){
    require_once "../db/db.php";
    require_once "../models/modelo.php";

    // conexion a bd
    $conexion = Bd::conexion();

    
    // Coger valores del post
    $dniCliente = $_POST["dniCliente"];
    $pwd = $_POST["pwd"];

    // Asignar valores al cliente
    $logingClient = new Cliente;
    $logingClient->dniCliente = $dniCliente;
    $logingClient->pwd = $pwd;

    if($logingClient->checkPassword($conexion)){ // Si la contraseña es correcta...

        $logingClient->fillClientInfo($conexion);

        // TODO: Enviar a function si se comprueba login
        if($logingClient->isAdmin == "1"){// Si es admin...
            header("Location: http://localhost/mrcoffee/mrcoffee/html/user-panel.html");
        } else {
            session_start();

            // Asignar valores de sesion
            $_SESSION["nombre"] = $logingClient->nombre;
            $_SESSION["dni"] = $logingClient->dniCliente;
            $_SESSION["total"] = 0;

            

            // Redirigir a pagina principal
            header("Location: http://localhost/mrcoffee/mrcoffee/php/controllers/principal.php");
        }
        
    } else {
        header("Location: http://localhost/mrcoffee/mrcoffee/html/index.html?error=1");
    }



}else {
    // Si no ha llegado a través del form de login le envia al mismo
    header("Location: http://localhost/mrcoffee/mrcoffee/html/index.html");
}