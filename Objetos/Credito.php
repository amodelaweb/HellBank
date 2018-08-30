<?php
    class Credito{
        private $id;
        private $cuotaManejo;
        private $tasaInteres;
        private $fechaPago;
        private $interesMora;
        function __construct($id,$cuotaManejo,$tasaInteres,$fechaPago,$interesMora){
            $this->id = $id;
            $this->cuotaManejo = $cuotaManejo;
            $this->tasaInteres = $tasaInteres;
            $this->fechaPago = $fechaPago;
            $this->interesMora = $interesMora;
        }
        function getId(){
            return $this->id;
        }
        function getCuotaManejo(){
            return $this->cuotaManejo;
        }
        function getTasaInteres(){
            return $this->tasaInteres;
        }
        function getFechaPago(){
            return $this->fechaPago;
        }
        function getInteresMora(){
            return $this->interesMora;
        }
    }
?>