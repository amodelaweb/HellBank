<?php
    class CuentaAhorros{
        private $id;
        private $cuotaManejo;
        private $idDueño;
        private $saldo;
        function __construct($id,$cuotaManejo,$idDueño,$saldo){
            $this->id = $id;
            $this->cuotaManejo = $cuotaManejo;
            $this->idDueño = $idDueño;
            $this->saldo = $saldo;
        }
    }
?>