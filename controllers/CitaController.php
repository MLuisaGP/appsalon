<?php
namespace Controller;

use MVC\Router;

class CitaController{
    public static function index(Router $router){
        $script="
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>";
        $router->render('cita/index',[
            'nombre'=>$_SESSION['nombre'],
            'script'=>$script,
            'id_usuario'=>$_SESSION['id']
        ]);
    }
}
