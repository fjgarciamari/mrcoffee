<?php

//GET Para entregar PHP antes cambiar a POST

require_once "../models/modelo.php";
require_once "../db/db.php";

// conexion a bd
$conexion = Bd::conexion();

$usuario = new Cliente;

$usuario->dniCliente = $_POST["dniCliente"];
$usuario->nombre = $_POST["nombre"];
$usuario->direccion = $_POST["direccion"];
$usuario->email = $_POST["email"];
$usuario->pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
$usuario->isAdmin = "1";

$usuario->modificarCliente($conexion);

$conexion->close();

echo $usuario->dniCliente." se ha modificado";