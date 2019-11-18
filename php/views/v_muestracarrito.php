<?php
echo "<div class='carrito'>";

// TODO: Añadir cabecera de la tabla / grid
echo "<form method='post'>";
echo "<input type='submit' name='actualizarCantidades' value='Actualizar calculos'>";
$totalCalculado = 0;
$totalCantidades = 0;

for ($i=0; $i < $_SESSION["total"]; $i++) { 
    if ($_SESSION["carrito"]["cantidad"][$i] > 0){
        echo "<div class='carrito__item'>";

        echo "<div class='carrito__item-idProducto'>".$_SESSION["carrito"]["idProducto"][$i]."</div>";
        //echo "<div class='carrito__item-foto'>".$_SESSION["carrito"]["foto"][$i]."</div>";
        echo "<div class='carrito__item-nombre'>".$_SESSION["carrito"]["nombre"][$i]."</div>";
        echo "<div class='carrito__item-cantidad'><input type='number' name='cantidad[]' value='".$_SESSION["carrito"]["cantidad"][$i]."'></div>";
        echo "<div class='carrito__item-precio'>".$_SESSION["carrito"]["precio"][$i]."</div>";

        //Añadir al total
        $totalCalculado = $totalCalculado + $_SESSION["carrito"]["cantidad"][$i] * $_SESSION["carrito"]["precio"][$i];
        $totalCantidades = $totalCantidades + $_SESSION["carrito"]["cantidad"][$i];

    echo "</div>";
    } else {
        // cambiar style a clases CSS
        echo "<div class='carrito__item--hidden' style='display: none;'>";
            echo "<div class='carrito__item-cantidad'><input type='number' name='cantidad[]' value='".$_SESSION["carrito"]["cantidad"][$i]."'></div>";
        
        echo "</div>";
    }
    
}
// 

echo "Subtotal (".$totalCantidades."): ".$totalCalculado."<br>";

echo "<a href='./confirmar.php'> Tramitar pedido </a>";
echo "<a href='./principal.php'> Seguir comprando </a>";

echo "</form>";

echo "</div>";
?>