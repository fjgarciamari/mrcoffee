<?php

require_once "../models/modelo.php";
require_once "../db/db.php";

// conexion a bd
$conexion = Bd::conexion();

$listaClientes = Cliente::getAll($conexion);

$clientesData = array();

while ($cliente = $listaClientes->fetch_assoc()){
    $clientesData[] = $cliente;
}

echo json_encode($clientesData);

$conexion->close();