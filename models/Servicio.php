<?php
    namespace Model;
    class Servicio extends ActiveRecord{
        //Base de datos
        protected static $tabla = 'servicios';
        protected static $idName ='id_servicio';
        protected static $columnasDB = [
            'id_servicio',
            'nombre_servicio',
            'precio',
        ];
        protected $id_servicio;
        protected $nombre_servicio;
        protected $precio;

        public function __construct($args =[]){

            $this->id_servicio=$args["id_servicio"]??null;
            $this->nombre_servicio=$args["nombre_servicio"]??'';
            $this->precio=$args["precio"]??'';
        }
        public function validar():array{
            if(!$this->nombre_servicio){
                self::$alertas['error'][]='El nombre del servicio es obligatorio';
            }
            if(!$this->precio){
                self::$alertas['error'][]='El precio del servicio es obligatorio';
            }elseif(is_numeric(!$this->precio) || $this->precio<0){
                self::$alertas['error'][]='El precio no es válido';
            }
            return self::$alertas;
        }
    }