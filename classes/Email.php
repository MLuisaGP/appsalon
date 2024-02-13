<?php

namespace Clases;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Email{
    public $email;
    public $nombre;
    public $token;
    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    public function enviarConfirmacion(){
        //crear el objeto email
        $mail = new PHPMailer();
        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PWD'];                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('luisagalazmp@galazcode.com', 'Mailer');
            $mail->addAddress('luisagalazmp@gmail.com', 'galazcode.com');     //Add a recipient 
            //Content
            $mail->isHTML(true);      
            $mail->CharSet = 'UTF-8';                            //Set email format to HTML
            $mail->Subject = 'Confirma tu cuenta';
            $contenido  = "<html>";
            $contenido .="<p><strong>Hola {$this->nombre}</strong> Has creado tu cuenta en App Salon, solo debes confirmala presionando el siguiente enlace</p>";
            $contenido .="<p>Preciona aquí:<a href='".$_ENV['APP_URL']."/confirmar-cuenta?token={$this->token}'>Confirmar Cuenta</a></p>";
            $contenido .="<p>Si tu no solicitaste esta cuenta, puedes ignorar este mensaje</p>";
            $contenido .="</html>";
            $mail->Body = $contenido;
        
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    public function enviarIntrucciones(){
        //crear el objeto email
        $mail = new PHPMailer();
        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PWD'];                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom('luisagalazmp@galazcode.com', 'Mailer');
            $mail->addAddress('luisagalazmp@gmail.com', 'galazcode.com');     //Add a recipient 
            //Content
            $mail->isHTML(true);      
            $mail->CharSet = 'UTF-8';                            //Set email format to HTML
            $mail->Subject = 'Reestablece tu Pwd';
            $contenido  = "<html>";
            $contenido .="<p><strong>Hola {$this->nombre}</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para realizarlo:</p>";
            $contenido .="<p>Preciona aquí:<a href='".$_ENV['APP_URL']."/recuperar?token={$this->token}'>Restablece contraseña</a></p>";
            $contenido .="<p>Solo se podra utilizar una sola vez el token</p>";
            $contenido .="<p>Si tu no solicitaste este cambio, puedes ignorar este mensaje</p>";
            $contenido .="</html>";
            $mail->Body = $contenido;
        
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

}