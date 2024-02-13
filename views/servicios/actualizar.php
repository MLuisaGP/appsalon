<?php include_once __DIR__ .'/../templates/barra.php';?>
<h1 class="nombre-pagina">Actualizar Servicio</h1>

<?php
    include_once __DIR__.'/../templates/alertas.php';
    if($servicio){
?>
    <p class="descripcion-pagina">Llena todos los campos para actualizar el servicio</p>
    <form method="POST" class="formulario">
        <?php
            include_once __DIR__."/formulario.php";
        ?>
    <input type="submit" value="Guardar Cambios" class="boton">
<?php } ?>
</form>