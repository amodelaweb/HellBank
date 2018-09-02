<?php
  //  requiere JVM
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../Objetos/Usuario.php';
  include_once '../../config/Database.php';
  include_once '../../config/AuthJson.php';

  $database = new Database();
  $conn = $database->connection();

  $usuario = new Usuario($conn) ;

  $datos = json_decode(file_get_contents("php://input"));

  $usuario->setUserName($datos->user_name);
  $inpu = $datos->password;

  $res = $usuario->Auth_Oth($inpu) ;

  if ($res == "success") {
      http_response_code(200);

      $my_token = new Token() ;
      $my_token->encode_key($usuario->getId(), $usuario->getRol()) ;

      echo json_encode(
        array('access_token' => $my_token->getJwtOwn(),
              'expires_in' => '86400',
              'rol' => $usuario->getRol() )
      );
  } elseif ($res == "error") {
      http_response_code(400);
      echo json_encode(
      array('error' => "error")
    );
  } else {
      http_response_code(400);
      echo json_encode(
      array('error' => "error")
    );
  }

  ?>
