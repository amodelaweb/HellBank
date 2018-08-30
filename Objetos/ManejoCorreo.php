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
    }
?>