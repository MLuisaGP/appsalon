<?php
    namespace Controller;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

    class APIController{
        public static function index(){
            $servicios = Servicio::all();
            $atributos=[];
            foreach ($servicios as $key => $value) {
                $atributoServicio=$value->atributos(false);//regresa el id_servicio
                $atributos[$key]=$atributoServicio;
            }
            echo json_encode($atributos);
        }

        public static function guardar(){
            $cita = new Cita($_POST);
            $resultado = $cita->guardar();
            $id_cita = $resultado['id'];
            $servicios=explode( ',', $_POST['servicios']);
            
            foreach ($servicios as $id_servicio) {
                $citaServicio = new CitaServicio(['id_cita'=>$id_cita,'id_servicio'=>$id_servicio]);
                $respuesta = $citaServicio->guardar();
            }
            echo json_encode($respuesta);
            
        }
        public static function eliminar(){
            if($_SERVER['REQUEST_METHOD']==='POST'){
                $id = $_POST["id"];
                $cita = Cita::find($id);
                $cita->eliminar();
                header('Location: '.$_SERVER['HTTP_REFERER']);
            }
        }
    }