<?php
    class Credito{
        private $id;
        private $monto ;
        private $cuotaManejo;
        private $tasaInteres;
        private $fechaPago;
        private $fechaCreado;
        private $interesMora;
        private $connection ;
        private $dueno  ;
        private $email_vis ;
        private $ultimo_pago ;
        
        function __construct($conn){
            $this->$connection = $conn ;
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
