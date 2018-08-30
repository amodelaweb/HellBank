<?php
    include_once dirname(__FILE__) . '/Usuario.php';
    include_once dirname(__FILE__) . '/ManejoCorreo.php';
    class Sistema{
        private $interes;
        private $usuarios = [];
        private $mailer;
        function __construct($interes){
            $this->interes = $interes;
        }
        function addUsuario($usuario){
            array_push($this->usuarios,$usuario);
        }
        function enviarMail($username,$correo,$asunto,$mensaje){
            $this->mailer = new ManejoCorreo($correo,$asunto,$mensaje);
            $this->mailer->enviarMail($username);
        }
    }
?>