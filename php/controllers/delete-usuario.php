<?php

require_once "../models/modelo.php";
require_once "../db/db.php";

// conexion a bd
$conexion = Bd::conexion();

$usuario = new Cliente;

$usuario->dniCliente = $_POST["dniCliente"];

$usuario->borrarCliente($conexion);

$conexion->close();

echo $usuario->dniCliente." se ha eliminado";