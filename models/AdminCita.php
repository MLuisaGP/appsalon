<?php

namespace Model;

class AdminCita extends ActiveRecord{
    //Base de datos
    protected static $tabla = 'citasservicios';
    protected static $idName ='id_admin_cita';
    protected static $columnasDB = [
        'id_admin_cita',
        'hora',
        'cliente',
        'email',
        'telefono',
        'servicio',
        'precio',
    ];
    protected $id_admin_cita;
    protected $hora;
    protected $cliente;
    protected $email;
    protected $telefono;
    protected $servicio;
    protected $precio;

    public function __construct($args =[]){
        $this->id_admin_cita=$args["id_admin_cita"]??null;
        $this->hora=$args["hora"]??'';
        $this->cliente=$args["cliente"]??'';
        $this->email=$args["email"]??'';
        $this->telefono=$args["telefono"]??'';
        $this->servicio=$args["servicio"]??'';
        $this->precio=$args["precio"]??0;
    }
    
    public function sincronizarId(){
        $this->id=$this->id_admin_cita;
    }
}