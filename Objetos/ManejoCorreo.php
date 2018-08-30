<?php
    class ManejoCorreo{
        private $correDestino;
        private $asunto;
        private $mensaje;
        function __construct($correoDestino, $asunto, $mensaje){
            $this->correoDestino = $correoDestino;
            $this->asunto = $asunto;
            $this->mensaje = $mensaje;
        }
        function enviar_mail($username){
            $mail = new PHPMailer(true);
            try {
                //Server settings
                //$mail->SMTPDebug = 3;                                 // Enable verbose debug output
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = "smtp.gmail.com";  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'soyunavenger128@gmail.com';                 // SMTP username
                $mail->Password = 'Andres1998';                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to
            
                //Recipients
                $mail->setFrom('soyunavenger128@gmail.com', 'PHPMailer');
                $mail->addAddress($this->correoDestino,$username);    
            
                //Content
                $mail->Subject = $this->asunto;
                $mail->Body = $this->mensaje;
            
                $mail->send();
                echo 'El mensaje fué enviado';
            } catch (Exception $e) {
                echo 'El mensaje no pudo ser enviado. Error: ', $mail->ErrorInfo;
            }
        }
    }
?>