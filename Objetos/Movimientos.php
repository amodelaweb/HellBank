<?php
    class MovimientosAdmin{

        private $id;
        private $id_admin ;
        private $id_producto ;
        private $fecha_realizado ;
        private $tipo_operacion ; 

        private $connection ;

        function __construct($conn){
            $this->$connection = $conn;
        }
      /* GETTERS Y SETTERS*/

    }
?>
