<?php
    class Retiro{
        private $id;
        private $monto;
        private $fecha;
        private $idCuenta;
        function __construct($id,$monto,$fecha,$idCuenta){
            $this->id = $id;
            $this->monto = $monto;
            $this->fecha = $fecha;
            $this->idCuenta = $idCuenta;
        }
    }
?>