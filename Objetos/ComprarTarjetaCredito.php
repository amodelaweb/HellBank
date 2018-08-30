<?php
    class ComprarTarjetaCredito{
        private $id;
        private $monto;
        private $fecha;
        private $numCuotas;
        private $moneda;
        function __construct($id,$monto,$fecha,$numCuotas,$moneda){
            $this->id = $id;
            $this->monto = $monto;
            $this->fecha = $fecha;
            $this->numCuotas = $numCuotas;
            $this->moneda = $moneda;
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