<?php
include_once dirname(__FILE__) . '/config/config.php';

class Database
{
    private $conn ;
    public function connection()
    {
      $this->conn = null ;
        try {
            $this->conn = new PDO('mysql:host=' . HOST_DB . ';dbname=' . NOMBRE_DB, USUARIO_DB, USUARIO_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Error de coneccion : " .  $e->getMessage();
        }

         return $this->conn;
    }
}
