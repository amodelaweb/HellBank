<?php
    class TarjetaCredito{

        var $estados = ["APROBADA","NO_APROBADA","EN_ESPERA"];
        private $id;
        private $cuotaManejo;
        private $idDueno;
        private $cupoMaximo;
        private $sobreCupo;
        private $tasaInteres;
        private $estado;
        function __construct($id,$cuotaManejo,$idDueno,$cupoMaximo,$sobreCupo,$tasaInteres){
            $this->id = $id;
            $this->cuotaManejo = $cuotaManejo;
            $this->idDueno = $idDueno;
            $this->cupoMaximo = $cupoMaximo;
            $this->sobreCupo = $sobreCupo;
            $this->tasaInteres = $tasaInteres;
            $this->estado = $this->estados[2];
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