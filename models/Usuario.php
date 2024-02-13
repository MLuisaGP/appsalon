<?php
namespace Model;

class Usuario extends ActiveRecord{
    //Base de datos
    protected static $tabla = 'usuarios';
    protected static $idName ='id_usuario';
    protected static $columnasDB=[
        'nombre_usuario',
        'apellido_usuario',
        'email',
        'password',
        'telefono',
        'admin',
        'confirmado',
        'token',
        
    ];

        protected $id_usuario;
        protected $nombre_usuario;
        protected $apellido_usuario;
        protected $email;
        protected $password;
        protected $telefono;
        protected $admin;
        protected $confirmado;
        protected $token;

        public function __construct($args =[]){

            $this->id_usuario=$args["id_usuario"]??null;
            $this->nombre_usuario=$args["nombre_usuario"]??'';
            $this->apellido_usuario=$args["apellido_usuario"]??'';
            $this->email=$args["email"]??'';
            $this->password=$args["password"]??'';
            $this->telefono=$args["telefono"]??'';
            $this->admin=$args["admin"]??'0';
            $this->confirmado=$args["confirmado"]??'0';
            $this->token=$args["token"]??'';
        }

        public function validarNuevaCuenta(){
            if(!$this->nombre_usuario){
                self::$alertas['error'][]='El Nombre es Obligatorio';
            }
            if(!$this->apellido_usuario){
                self::$alertas['error'][]='El Apellido es Obligatorio';
            }
            if(!$this->email){
                self::$alertas['error'][]='El Email es Obligatorio';
            }else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
                self::$alertas['error'][]='Favor de introducir un correo válido';
            }
            if(!$this->telefono){
                self::$alertas['error'][]='El telefono es Obligatorio';
            }elseif(strlen($this->telefono)!==10){
                self::$alertas['error'][]='Favor de introducir un número de teléfono válido';
            }
            if(!$this->password){
                self::$alertas['error'][]='La Contraseña es obligatoria';
            }elseif(strlen($this->password)<5){
                self::$alertas['error'][]='La Contraseña debe de ser mayor a 5 Caracteres';
            }
            return self::$alertas;
        }
        
        public function validarLogin(){
            if(!$this->email){
                self::$alertas['error'][]='El email es obligatorio';
            }
            if(!$this->password){
                self::$alertas['error'][]='La contraseña es obligatoria ';
            }
            return self::$alertas;
        }

        public function validarEmail(){
            if(!$this->email){
                self::$alertas['error'][]='El email es obligatorio';
            }
            return self::$alertas;
        }
        public function validarPwd(){
            if(!$this->password){
                self::$alertas['error'][]='La Contraseña es obligatori  ';
            }elseif(strlen($this->password)<5){
                self::$alertas['error'][]='La Contraseña debe de ser mayor a 5 Caracteres';
            }
            return self::$alertas;
        }

        public function existeUsuario():bool{
            $query = "SELECT * FROM ". self::$tabla." WHERE email = '{$this->email}' LIMIT 1;";
            // debuguear($query);
            $resultado = self::$db->query($query);
            if($resultado->num_rows){
                self::$alertas['error'][]='Correo ya registrado';
                return false;
            }
            return true;
        }

        public function hashPassword(){
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }
        public function crearToken(){
            $this->token = uniqid();
        }

        public function comprobarPasswordAndVerificado($pwd){
            $resultado = password_verify($pwd,$this->password);
            if(!$this->confirmado ||!$resultado){
                self::$alertas['error'][]='Password Incorrecto o tu cuenta no ha sido confirmada';
            }else{
                return true;
            }
        }
    }