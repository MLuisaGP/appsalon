<?php
namespace Controller;

use Clases\Email;
use MVC\Router;
use Model\Usuario;
class LoginController{
    public static function login(Router $router){
        $alertas=[];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
          $auth = new Usuario($_POST);
            $alertas=$auth->validarLogin();
            if(empty($alertas)){
                $atributos = $auth->atributos();
                $usuario = Usuario::where('email', $atributos['email']);
                if($usuario){
                    //verificar pwd
                   if( $usuario->comprobarPasswordAndVerificado($atributos['password'])){
                    //autenticar al usuario
                    if (session_status() == PHP_SESSION_NONE) {//verificar que el estatus no ha iniciado
                        session_start();
                    }
                    $atributos = $usuario->atributos(false);
                    $_SESSION['id'] = $usuario->getValor('id_usuario');
                    $_SESSION['nombre'] = "{$atributos['nombre_usuario']} {$atributos['apellido_usuario']}";
                    $_SESSION['email'] = $atributos['email'];
                    $_SESSION['login'] = true;
                    //redireccionamiento
                    if($usuario->getValor('admin')==="1"){
                        $_SESSION['admin'] = $atributos['admin']??null;
                        header('Location: /admin');
                    }else{
                        header('Location: /cita');
                    }
                   }
                }else{
                    Usuario::setAlerta('error','Usuario no encontrado');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/login',[
            "alertas"=> $alertas
        ]);
    }
    public static function logout(Router $router){
        if (session_status() == PHP_SESSION_NONE) {//verificar que el estatus no ha iniciado
            session_start();
        }
        $_SESSION =[];
        header('Location: /');
    }
    public static function olvide(Router $router){
        $alertas=[];
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $auth = new Usuario($_POST);
            $alertas=$auth->validarEmail();
            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->getValor('email'));
                if($usuario && $usuario->getValor('confirmado')=='1'  ){
                    
                    //Generar un token de un solo uso
                    $usuario->crearToken();
                    $usuario->guardar();
                    //enviar el email
                    $atributos=$usuario->atributos();
                    $email = new Email(email: $atributos['email'],nombre: $atributos['nombre_usuario'],token:$atributos['token'] );
                    $email->enviarIntrucciones();
                    //eAlerta existo
                    Usuario::setAlerta('exito','Revisa tu email');
                }else{
                    Usuario::setAlerta('error', 'El Usuario no existe o no esta confirmado');
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide-pwd',[
            'alertas'=>$alertas
        ]);
    }
    public static function recuperar(Router $router){
        $alertas=[];
        $error = false;
        $token = s($_GET['token']??'');
        if($token !=null){
            $usuario = Usuario::where('token',$token);
            if(empty($usuario)){
                Usuario::setAlerta('error','Token no válido');
                $error = true;
            }
            else{
                $usuario->setValor('token',null);
               if($_SERVER['REQUEST_METHOD']==='POST'){
                //LEER EL NUEVO PASSWORD Y GUARDARLO
                $pwd = new Usuario(($_POST));
                $pwd->validarPwd();
                if(empty($alertas)){
                    $usuario->setValor('password',null);
                    
                    $password = $pwd->getValor('password');
                    $usuario->setValor('password',$password);
                    $usuario->hashPassword();
                   $resultado = $usuario->guardar();
                   if($resultado){
                    header('Location: /');
                   }
                }
               }
               
            }
        }else{
            Usuario::setAlerta('error','Token no válido');
            $error = true;
        }
        
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-pwd',[
            "alertas"=> $alertas,
            "error"=>$error
        ]);
    }

    public static function crear(Router $router){
        $usuario = new Usuario;
        $atributos = $usuario->atributos();
        $alertas=[];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $atributos =$usuario->sincronizar($_POST);
            $alertas=$usuario->validarNuevaCuenta();
            if(empty($alertas)){
               $isValid=$usuario->existeUsuario();
               if(!$isValid){
                   $alertas = Usuario::getAlertas();
               }else{
                //Hashear el Password
                $usuario->hashPassword();
                //Generar Tocken
                $usuario->crearToken();
                $atributos = $usuario->atributos();
                //Enviar el email
                $email = new Email($atributos['email'],$atributos['nombre_usuario'],$atributos['token'],);
                $email->enviarConfirmacion();
                //crear el usuario
                $resultado = $usuario->guardar();
                if($resultado){
                    header('Location: /mensaje');
                }
               }
            }
        }
        $router->render('auth/crear',[
            'usuario'=>$atributos,
            'alertas'=>$alertas,
        ]);
    }
    
    public static function mensaje(Router $router){
        $router->render('auth/mensaje',[
        ]);
    }
    
    public static function confirmar(Router $router){
        $alertas=[];
        $token = s($_GET['token']??'');
        if($token !=null){
            $usuario = Usuario::where('token',$token);
            if(empty($usuario)){
                Usuario::setAlerta('error','Token no válido');
            }
            else{
                $usuario->setValor('token',null);
                $usuario->setValor('confirmado','1');
                $usuario->guardar();
                Usuario::setAlerta('exito',"Cuenta Comprobada Correctamente");
            }
        }else{
            Usuario::setAlerta('error','Token no válido');
        }
        
        $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta',[
            'alertas' => $alertas
        ]);
    }

}