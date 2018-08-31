<?php
    class Usuario{

        private $id;
        private $user_name ;
        private $nombre;
        private $apellido;
        private $email;
        private $rol;

        private $connection ;

        function __construct($conn){
            $this->$connection = $conn;
        }
        /* GETTERS Y SETTERS*/
        function getId(){
            return $this->id;
        }
        function getEmail(){
            return $this->email;
        }
        function getRol(){
            return $this->rol;
        }
    }
?>
