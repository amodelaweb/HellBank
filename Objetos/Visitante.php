<?php
    class Visitante{

        private $email;
        private $nombre ;
        private $apellido; 
        private $cedula;
        private $connection;

        function __construct($conn){
            $this->connection = $conn;
        }
        /* GETTERS AND SETTERS */
        function getEmail(){
            return $this->email;
        }
        function getCedula(){
            return $this->cedula;
        }
    }
?>
