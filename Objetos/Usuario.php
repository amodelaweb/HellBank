<?php
    include_once dirname(__FILE__) . '/CentroMensajes.php';
    class Usuario{
        private $id;
        private $email;
        private $rol;
        function __construct($id, $email,$rol){
            $this->id = $id;
            $this->email = $email;
            $this->rol = $rol;
        }
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