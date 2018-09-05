<?php

require_once('PHPMailer_5.2.4/class.phpmailer.php');
include("PHPMailer_5.2./class.smtp.php");
include_once 'mail.php';

class ManejoCorreo{
  private $correDestino;
  private $asunto;
  private $mensaje;
  private $connection ;
  function __construct($correoDestino, $asunto, $mensaje){
    $this->correoDestino = $correoDestino;
    $this->asunto = $asunto;
    $this->mensaje = $mensaje;
  }
  function enviar_mail($username){
    $ella =  EMAIL ;
    $mail  = new PHPMailer();
    $body = $this->mensaje;
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = SMTP_SEC;
    $mail->Host = HOST;
    $mail->Port = E_PORT ;
    $mail->Username = EMAIL;
    $mail->Password = E_PASSWORD;
    $mail->SetFrom(EMAIL, REMITENT);
    $mail->Subject = $this->asunto;
    $mail->Body = $body ;
    $mail->AddAddress($this->correoDestino, "Apreciado Sr./Sra.");

    if(!$mail->Send()) {
      return true ;
    } else {
      return false ;
    }

  }
}
?>
