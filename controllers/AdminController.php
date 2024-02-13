<?php
namespace Controller;

use Model\AdminCita;
use Model\ActiveRecord;
use MVC\Router;

class AdminController{
    public static function index(Router $router){
        $fecha = $_GET['fecha']??date('Y-m-d');
        $fechas = explode("-",$fecha);
        if(!checkdate($fechas[1],$fechas[2],$fechas[0])){
            header('Location: /404');
        }

        $alertas=[];
        $consulta = "SELECT citas.id_cita as id_admin_cita,citas.hora, ";
        $consulta .="concat(nombre_usuario,' ',apellido_usuario) as cliente, usuarios.email, usuarios.telefono, ";
        $consulta .="servicios.nombre_servicio as servicio, servicios.precio ";
        $consulta .="FROM appsalon.citas ";
        $consulta .="LEFT OUTER JOIN usuarios on  citas.id_usuario = usuarios.id_usuario ";
        $consulta .="LEFT OUTER JOIN citasservicios on citasservicios.id_cita = citas.id_cita ";
        $consulta .="LEFT OUTER JOIN servicios on servicios.id_servicio = citasservicios.id_servicio ";
        $consulta .="WHERE fecha = '$fecha' ";
        $citas = AdminCita::SQL($consulta);
        $citasAtributos=[];
        foreach ($citas as $cita) {
            $citaAtributos=$cita->atributos(false);
            $citasAtributos[]=$citaAtributos;
        }
        if(empty($citasAtributos)){
            $alertas['warning'][]='No hay Citas';
        }
        $script="
        <script src='build/js/buscador.js'></script>";
        $router->render('admin/index',[
            'alertas'=>$alertas,
            'nombre'=>$_SESSION['nombre'],
            'citas'=>$citasAtributos,
            'fecha'=>$fecha,
            'script'=>$script
        ]);
    }
    
}