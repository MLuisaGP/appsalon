<?php include_once __DIR__ .'/../templates/barra.php'?>
<h1 class="nombre-pagina">Panel de Administracion</h1>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form action="" class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="<?php  echo $fecha; ?>">
        </div>
    </form>
</div>
<?php
include_once __DIR__.'/../templates/alertas.php';
?>
<div id="citas-admin">
    <ul class="citas">
        <?php 
            $idCita = 0;
            foreach($citas as $key => $cita)://*inicio foreach
                if($idCita !==$cita['id_admin_cita'])://*inicio if
                    $total = 0;
                    $idCita = $cita['id_admin_cita']; //siempre obtiene el utimo id
                ?>
                <li>
                    <p>ID: <span><?php echo $cita['id_admin_cita']; ?></span></p>
                    <p>HORA: <span><?php echo $cita['hora']; ?></span></p>
                    <p>Cliente: <span><?php echo $cita['cliente']; ?></span></p>
                    <p>Email: <span><?php echo $cita['email']; ?></span></p>
                    <p>Telefono: <span><?php echo $cita['telefono']; ?></span></p>
                    <h3>Servicios</h3>
                <?php endif;?> <!--//*fin if-->
                <p class="servicios"><?php echo $cita['servicio']." $". $cita['precio'];?> </p>
                <?php 
                    $actual = $cita['id_admin_cita']; //nos regresa el id donde nos enontramos
                    $proximo = $citas[$key + 1]['id_admin_cita']??0;//obtienes el id del siguiente registro
                    $total += $cita['precio'];
                    if(esUltimo($actual,$proximo)):?>
                        <p class="total">Total: <span><?php echo "$$total"; ?></span></p>
                        <form action="/api/eliminar" method="POST">
                            <input type="hidden" name="id" value="<?php echo $cita['id_admin_cita'] ?>">
                            <input type="submit" class="boton-eliminar" value="Eliminar" >
                        </form>
                        </li> 
                    <?php endif ?>
        <?php endforeach; ?><!--//*fin foreach-->
    </ul>
    
</div>