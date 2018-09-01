<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../Objetos/Usuario.php';
  include_once '../../config/Database.php';

  $database = new Database();
  $conn = $database->connection();

  $usuario = new Usuario($conn) ;

  $datos = json_decode(file_get_contents("php://input"));

  $usuario->setUserName($datos->user_name);
  $usuario->setNombre($datos->nombre);
  $usuario->setApellido($datos->apellido);
  $usuario->setPassword($datos->password);
  $usuario->setEmail($datos->email);

  $res = $usuario->Registrar_Usuario() ;

  if($res == "exito") {
    http_response_code(201);
    echo json_encode(
      array('Resultado' =>  $res)
    );
  }else if ($res == "error"){
    http_response_code(400);
    echo json_encode(
      array('Resultado' => "foreign error")
    );
  }else{
    http_response_code(400);
    echo json_encode(
      array('Resultado' => $res)
    );
  }

?>
