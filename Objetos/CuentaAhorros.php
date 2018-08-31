<?php
    class CuentaAhorros{
        private $id;
        private $cuotaManejo;
        private $tasa_interes ;
        private $fecha_creado ;     
        private $idDueno;
        private $saldo;
        private $connection ;
        function __construct($conn){
            $this->$connection = $conn ;
        }
        function getId(){
            return $this->id;
        }
        function getCuotaManejo(){
            return $this->cuotaManejo;
        }
        function getIdDueno(){
            return $this->idDueno;
        }
        function getSaldo(){
            return $this->saldo;
        }
    }
?>
