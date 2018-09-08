<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../../Objetos/Usuario.php';
  include_once '../../../config/Database.php';
  include_once '../../../config/AuthJson.php';

  $header = getallheaders() ;
  $token =  $header['x-api-key']  ;
  $my_token = new Token() ;
  $res = $my_token->decoding_key($token) ;
  if ($res != false) {
      if (Token::is_valid_admin($my_token)) {
          $database = new Database();
          $conn = $database->connection();
          $datos = json_decode(file_get_contents("php://input"));

          $response_f = Usuario::makeUser($conn , $datos->usr_id);
          if ($response_f) {
              http_response_code(200);
              echo json_encode(array ('exito' => 'Usuario es admin'));
          } else {
              http_response_code(400);
              echo json_encode(
          array('mensaje' => 'Error bad user.')
        );
          }
      } else {
          http_response_code(401);
          echo json_encode(
        array('error' => 'Sesion Invalida')
      );
      }
  } else {
      http_response_code(401);
      echo json_encode(
      array('error' => 'sesion invalida')
    );
  }

?>
