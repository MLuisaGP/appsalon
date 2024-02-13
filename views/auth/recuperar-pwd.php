<h1 class="nombre-pagina">Restablecer contraseña</h1>
<p class="descripcion-pagina">Coloca tu nueva contraseña.</p>
<?php include_once __DIR__.'/../templates/alertas.php';
?>
<?php
    if($error) return null;
?>
<form class="formulario" method="POST">
    
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Tu Nueva contraseña">
    </div>
    <input class="boton" type="submit" value="Restablecer contraseña">
</form>
<div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión.</a>
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crear Una.</a>
</div>