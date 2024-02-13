<?php
    foreach($alertas as $key =>$mensajes){
        foreach($mensajes as $mensaje){
        echo "<p class='alerta $key'>$mensaje</p>";
        }
    }
?>