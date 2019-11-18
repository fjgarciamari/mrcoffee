<?php

echo "<div class='detalle-producto' >";

echo "<div class='detalle-producto detalle-producto__foto'>";
echo "<img src='$producto->foto'>";
echo "</div>";

echo "<div class='detalle-producto detalle-producto__nombre'>";
echo $producto->nombre;
echo "</div>";

echo "<div class='detalle-producto detalle-producto__tipo-molido'>";
echo "Tipo:".$producto->tipoMolido;
echo "</div>";

echo "<div class='detalle-producto detalle-producto__precio'>";
echo $producto->precio."€";
echo "</div>";

echo "<form class='detalle-producto detalle-producto__form-compra' action='/mrcoffee/mrcoffee/php/controllers/vercarrito.php' method='post'>";

echo "<input type='hidden' name='idProducto' value='$producto->idProducto'>";
echo "<input type='hidden' name='nombre' value='$producto->nombre'>";
echo "<input type='hidden' name='foto' value='$producto->foto'>";
echo "<input type='hidden' name='precio' value='$producto->precio'>";

echo "<div class='detalle-producto detalle-producto__cantidad'> Cantidad:";
echo "<input type='number' name='cantidad'>";
echo "</div>";

echo "<input type='submit' name='comprar' value='Comprar'>";

echo "</form>";



echo "</div>";