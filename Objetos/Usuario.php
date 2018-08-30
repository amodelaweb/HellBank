<?php
    class Usuario{
        private $id;
        private $email;
        private $rol;
        function __construct($id, $email,$rol){
            $this->id = $id;
            $this->email = $email;
            $this->rol = $rol;
        }
    }
?>