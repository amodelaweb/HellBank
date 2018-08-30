<?php
    class Credito{
        private $id;
        private $cuotaManejo;
        private $tasaInteres;
        private $fechaPago;
        private $interesMora;
        private $rol;
        private $idDueño;
        function __construct($id,$cuotaManejo,$tasaInteres,$fechaPago,$interesMora,$rol,$idDueño){
            $this->id = $id;
            $this->cuotaManejo = $cuotaManejo;
            $this->tasaInteres = $tasaInteres;
            $this->fechaPago = $fechaPago;
            $this->interesMora = $interesMora;
            $this->rol = $rol;
            $this->idDueño = $idDueño;
        }
    }
?>