<?php
    class ComprarTarjetaCredito{
        private $id;
        private $id_producto  ;
        private $monto;
        private $fecha;
        private $numCuotas;
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
        function getNumCuotas(){
            return $this->numCuotas;
        }
        function getMoneda(){
            return $this->moneda;
        }
    }
?>
