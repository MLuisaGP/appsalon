<?php include_once __DIR__ .'/../templates/barra.php'?>
<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de Servicios</p>
<ul class="servicios">
    <?php foreach($servicios as $servicio):?>
        <li>
            <p> Nombre: <span><?php echo $servicio['nombre_servicio'] ?></span> </p>
            <p> Precio: <span>$ <?php echo $servicio['precio'] ?></span>  </p>
            <div class="acciones">
                <a class="boton" href="/servicios/actualizar?id=<?php echo$servicio['id_servicio']?>">Actualizar</a>
                <form action="/servicios/eliminar" method="post">
                    <input type="hidden" name="id_servicio" value="<?php echo$servicio['id_servicio']?>">
                    <input type="submit" value="Borrar" class="boton-eliminar">
                </form>
            </div>
        </li>
    <?php endforeach; ?>
</ul>