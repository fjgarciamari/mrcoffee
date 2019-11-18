<?php

?>
<div class="nombre-tienda"> Mr. Coffee </div>

<div class="cabecera">
    <p> Bienvenido
    <?php
        echo $_SESSION["nombre"];
    ?>
    </p>    

    <div>
        
        <a href="../controllers/vercarrito.php">
        <div class="carrito-icon">
            
            <div class="carrito-counter">
            <?php 
                echo $_SESSION["total"];
            ?>
            </div>
        </div>
        </a>
    </div>

</div>