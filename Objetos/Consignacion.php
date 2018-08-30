<?php
    class Consignacion{
        private $id;
        private $monto;
        private $fecha;
        private $idDestino;
        private $moneda;
        function __construct($id,$monto,$fecha,$idDestino,$moneda){
            $this->id = $id;
            $this->monto = $monto;
            $this->fecha = $fecha;
            $this->idDestino = $idDestino;
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
        function getIdDestino(){
            return $this->idDestino;
        }
        function getMoneda(){
            return $this->moneda;
        }
    }
?>