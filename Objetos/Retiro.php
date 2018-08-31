<?php
    class Retiro{
        private $id;
        private $idCuenta;
        private $monto;
        private $fecha;
        private $connection ;

        function __construct($conn){

            $this->$connection = $conn ;
        }
    }
?>
