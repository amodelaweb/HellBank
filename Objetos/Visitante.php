<?php
    class Visitante{
        private $email;
        private $cedula;
        function __construct($email, $cedula){
            $this->email = $email;
            $this->cedula = $cedula;
        }
        function getEmail(){
            return $this->email;
        }
        function getCedula(){
            return $this->cedula;
        }
    }
?>