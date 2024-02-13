<?php
namespace Model;

class CitaServicio extends ActiveRecord{
        //Base de datos
        protected static $tabla = 'citasservicios';
        protected static $idName ='id_citasservicio';
        protected static $columnasDB = [
            'id_citasservicio',
            'id_cita',
            'id_servicio',
        ];
        protected $id_citasservicio;
        protected $id_cita;
        protected $id_servicio;

        public function __construct($args =[]){

            $this->id_citasservicio=$args["id_citasservicio"]??null;
            $this->id_cita=$args["id_cita"]??'';
            $this->id_servicio=$args["id_servicio"]??'';
        }
        public function sincronizarId(){
            $this->id=$this->id_citasservicio;
        }
}