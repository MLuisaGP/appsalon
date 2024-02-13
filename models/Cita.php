<?php
namespace Model;

class Cita extends ActiveRecord{
        //Base de datos
        protected static $tabla = 'citas';
        protected static $idName ='id_cita';
        protected static $columnasDB = [
            'id_cita',
            'fecha',
            'hora',
            'id_usuario',
        ];
        protected $id_cita;
        protected $fecha;
        protected $hora;
        protected $id_usuario;

        public function __construct($args =[]){

            $this->id_cita=$args["id_cita"]??null;
            $this->fecha=$args["fecha"]??'';
            $this->hora=$args["hora"]??'';
            $this->id_usuario=$args["id_usuario"]??'';
        }
}