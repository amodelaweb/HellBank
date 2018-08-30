<?php
    include_once dirname(__FILE__) . '/Estado.php';
    class TarjetaCredito{
        private $id;
        private $cuotaManejo;
        private $idDueño;
        private $cupoMaximo;
        private $sobreCupo;
        private $tasaInteres;
        private $estado;
        function __construct($id,$cuotaManejo,$idDueño,$cupoMaximo,$sobreCupo,$tasaInteres){
            $this->id = $id;
            $this->cuotaManejo = $cuotaManejo;
            $this->idDueño = $idDueño;
            $this->cupoMaximo = $cupoMaximo;
            $this->sobreCupo = $sobreCupo;
            $this->tasaInteres = $tasaInteres;
            $this->estado = new Estado(Estado::EN_ESPERA);
        }
    }
?>