<?php

namespace Controller;

use Model\Servicio;
use MVC\Router;

class ServicioController{
    public static function index(Router $router){
        $servicios = Servicio::all();
        $serviciosA=[];
        foreach ($servicios as $servicio) {
            $serviciosA[] = $servicio->atributos(false);
        }
        $router->render('servicios/index',[
            'nombre'=>$_SESSION['nombre'],
            'servicios'=>$serviciosA
        ]);
    }
    public static function crear(Router $router){
        $servicio = new Servicio;
        $alertas = [];
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();
            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
            }
        }
        $servicioA=$servicio->atributos();
        $router->render('servicios/crear',[
            'nombre'=>$_SESSION['nombre'],
            'servicio'=>$servicioA,
            'alertas'=>$alertas
        ]);
    }
    public static function actualizar(Router $router){
        $idServicio = $_GET['id']??'';
        if(!is_numeric($idServicio)){
            header('Location: /admin');
        }
        $servicio=Servicio::find($idServicio);
        if(!$servicio){
            Servicio::setAlerta('error','No se encontro servicio');
        }if($_SERVER['REQUEST_METHOD']==='POST'){
            $servicio->sincronizar($_POST);
            $alertas=$servicio->validar();
            if(empty($alertas)){
                $servicio->guardar();
                header('Location: /servicios');
            }
        }
        $alertas=Servicio::getAlertas();
        $servicioA=!$servicio?null:$servicio->atributos();
        $router->render('servicios/actualizar',[
            'nombre'=>$_SESSION['nombre'],
            'servicio'=>$servicioA,
            'alertas'=>$alertas
        ]);
    }
    public static function eliminar(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id_servicio'];
            $servicio = Servicio::find($id);
            $servicio->eliminar();
            header('Location: /servicios');
        }
    }
}