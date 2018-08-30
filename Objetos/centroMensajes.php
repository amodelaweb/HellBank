<?php
    class CentroMensajes{
        private $idCliente;
        private $mensaje;
        function __construct($idCliente,$mensaje){
            $this->idCliente = $idCliente;
            $this->mensaje = $mensaje;
        }
    }
?>