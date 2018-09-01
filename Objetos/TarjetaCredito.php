<?php
    class TarjetaCredito{

        var $estados = ["APROBADA","NO_APROBADA","EN_ESPERA"];
        private $id;
        private $idDueno;
        private $cupoMaximo;
        private $sobreCupo;
        private $gastado ;
        private $cuotaManejo;
        private $tasaInteres;
        private $estado;
        private $fecha_creado ;
        private $fecha_ultimo_pago ; 
        private $connection ;

        function __construct($conn){
            $this->$connection = $conn ;
        }
        /* GETTERS AND SETTERS */
        function getId(){
            return $this->id;
        }
        function getCuotaManejo(){
            return $this->cuotaManejo;
        }
        function getIdDueno(){
            return $this->idDueno;
        }
        function getCupoMaximo(){
            return $this->cupoMaximo;
        }
        function getSobreCupo(){
            return $this->sobreCupo;
        }
        function getTasaInteres(){
            return $this->tasaInteres;
        }
        function getEstado(){
            return $this->estado;
        }
        function setEstado($estado){
            return $this->estado = $estado;
        }
    }
?>
