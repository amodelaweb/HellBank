<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../Objetos/Usuario.php';
  include_once '../../config/Database.php';
  include_once '../../config/my_key.php';

  $database = new Database();
  $conn = $database->connection();

  $usuario = new Usuario($conn) ;

  $datos = json_decode(file_get_contents("php://input"));


?>
