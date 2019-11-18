<?php

require_once "../models/modelo.php";
require_once "../db/db.php";

// conexion a bd
$conexion = Bd::conexion();

$producto = new Producto;

$producto->nombre = $_POST["nombre"];
$producto->origen = $_POST["origen"];
$producto->tipoMolido = $_POST["tipoMolido"];
$producto->marca = $_POST["marca"];
$producto->peso = $_POST["peso"];
$producto->unidades = $_POST["unidades"];
$producto->precio = $_POST["precio"];

/* Getting file name */
$filename = $_FILES['foto']['name'];

/* Location */
$location = "../../img/products/".$filename;
$uploadOk = 1;
$imageFileType = pathinfo($location,PATHINFO_EXTENSION);

// Valid Extensiones validas
$valid_extensions = array("jpg","jpeg","png");
// Comprobar extensiones del fichero
if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
   $uploadOk = 0;
}
if($uploadOk == 0){
    $arrayResult = array("error" => true);
    echo json_encode($arrayResult);
}else{
   // Subir fichero
   if(move_uploaded_file($_FILES['foto']['tmp_name'],$location)){
      $producto->foto = "/mrcoffee/mrcoffee/img/products/".$filename;
      if($producto->guardarProducto($conexion)){
        $fotoUrl = $producto->foto;
        $arrayResult = array("fotoUrl" => $fotoUrl, "idProducto" => mysqli_insert_id($conexion));
        echo json_encode($arrayResult);
    } else {
        $arrayResult = array("error" => true);
        echo json_encode($arrayResult);
    }
   }else{
        $arrayResult = array("error" => true);
        echo json_encode($arrayResult);
   }
}




$conexion->close();

