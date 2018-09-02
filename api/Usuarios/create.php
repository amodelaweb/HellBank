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
  $datos->email = str_replace("%40","@",$datos->email);
  $usuario->setUserName($datos->user_name);
  $usuario->setNombre($datos->nombre);
  $usuario->setApellido($datos->apellido);
  $usuario->setPassword($datos->password);
  $usuario->setEmail($datos->email);

  $res = $usuario->Registrar_Usuario() ;

  if($res == "exito") {
    $res = str_replace("SQLSTATE[23000]: Integrity constraint violation","",$res);
    $res = str_replace("for key","",$res);
    $res = str_replace("for key","",$res);
    $res = str_replace("1062","",$res);

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
    $res = str_replace("SQLSTATE[23000]: Integrity constraint violation","",$res);
    $res = str_replace("for key","",$res);
    $res = str_replace("for key","",$res);
    $res = str_replace("1062","",$res);

    http_response_code(400);
    echo json_encode(
      array('Resultado' => $res)
    );
  }

?>
