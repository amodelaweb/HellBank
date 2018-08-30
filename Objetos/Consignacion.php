<?php
    include_once dirname(__FILE__) . '/TipoMoneda.php';
    class Consignacion{
        private $id;
        private $monto;
        private $fecha;
        private $idDestino;
        private $moneda;
        function __construct($id,$monto,$fecha,$idDestino,$moneda){
            $this->id = $id;
            $this->monto = $monto;
            $this->fecha = $fecha;
            $this->idDestino = $idDestino;
            $this->moneda = new TipoMoneda(TipoMoneda::$moneda);
        }
    }
?>