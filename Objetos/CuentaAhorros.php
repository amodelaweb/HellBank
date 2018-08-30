<?php
    class CuentaAhorros{
        private $id;
        private $cuotaManejo;
        private $idDueno;
        private $saldo;
        function __construct($id,$cuotaManejo,$idDueno,$saldo){
            $this->id = $id;
            $this->cuotaManejo = $cuotaManejo;
            $this->idDueno = $idDueno;
            $this->saldo = $saldo;
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