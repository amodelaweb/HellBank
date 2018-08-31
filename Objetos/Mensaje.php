<?php
    class Mensaje{
        private $idCliente;
        private $idAdmin;
        private $mensaje;
        private $id ; 
        private $connection ;
        function __construct($conn){
            $this->connection = $conn ;
        }
    }
?>
