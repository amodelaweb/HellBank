<?php
    class Credito{
        private $id;
        private $tasaInteres;
        private $interesMora;
        private $monto ;
        private $fechaCreado;
        private $dueno  ;
        private $email_vis ;
        private $ultimo_pago ;
        private $connection ;

        function __construct($conn){
            $this->connection = $conn ;
        }

    }
?>
