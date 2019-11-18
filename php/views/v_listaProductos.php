<div class="lista-productos">

<?php
    while ($producto = $listaProductos->fetch_assoc()){

        echo "<a href='./Detalle.php?idProducto=".$producto["idProducto"]."'> ";
        echo "<div class='producto'>";
        echo "<div class='producto__atributo producto__atributo--foto'>"."<img src='".$producto["foto"]."'>"." </div>";
        echo "<div class='producto__atributo producto__atributo--nombre'>".$producto["nombre"]." </div>";
        echo "<div class='producto__atributo producto__atributo--tipoMolido'>".$producto["tipoMolido"]." </div>";
        echo "<div class='producto__atributo producto__atributo--precio'>".$producto["precio"]." € </div>";
        
        echo "</div>";
        echo "</a>";
    }

?>

</div>