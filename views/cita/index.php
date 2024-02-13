<?php include_once __DIR__ .'/../templates/barra.php'?>
<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>
<div id="app">
    <nav class="tabs">
        <button class="actual" type="button " data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Infromacion</button>
        <button type="button" data-paso="3">Resumen</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>
        <form action="" class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input id="nombre" type="text" placeholder="Tu Nombre" value="<?php echo $nombre?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <!-- <input id="fecha" type="date" min="<?php //echo date('Y-m-d',strtotime(('+ 1day')))?>" > Hace que se seleciones hasta el dia sieguiente -->
                <input id="fecha" type="date" min="<?php echo date('Y-m-d')?>" > 
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input id="hora" type="time" >
            </div>
            <input id="id_usuario" type="hidden" value="<?php echo $id_usuario;?>" >
        </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        
    </div>
    <div class="paginacion">
        <button id="anterior" class="boton"> &laquo; Anterior</button><!--Añade fñechas en la direccion izq-->
        <button id="siguiente" class="boton"> Siguiente &raquo;</button><!--Añade fñechas en la direccion izq-->
    </div>
</div>
