<?php
    class ConsignacionDebito{
        private $id;
        private $monto;
        private $fecha;
        private $idDestino;
        private $moneda;
        private $connection ;

        function __construct($conn){
            $this->$connection = $conn ;
        }
        function getId(){
            return $this->id;
        }
        function getMonto(){
            return $this->monto;
        }
        function getFecha(){
            return $this->fecha;
        }
        function getIdDestino(){
            return $this->idDestino;
        }
        function getMoneda(){
            return $this->moneda;
        }
    }
?>
