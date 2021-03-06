<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../Objetos/Consignacion.php';
  include_once '../../config/Database.php';
  include_once '../../config/AuthJson.php';

  $header = getallheaders() ;
  $token =  $header['x-api-key']  ;
  $my_token = new Token() ;
  $res = $my_token->decoding_key($token) ;
  if ($res != false) {
    if (Token::is_valid_user($my_token)) {
      $database = new Database();
      $conn = $database->connection();
      $response_f = Consignacion::get_user_consignaciones_credito( $conn , $my_token->getId());
      if( $response_f['band'] ){
        http_response_code(200);
        echo json_encode($response_f['msn']);
      }else{
        http_response_code(400);
        echo json_encode(
          array('mensaje' => $response_f['msn'])
        );
      }
    }else{
      http_response_code(401);
      echo json_encode(
        array('error' => 'Sesion Invalida')
      );
    }
  }else{
    http_response_code(401);
    echo json_encode(
      array('error' => 'sesion invalida')
    );
  }

?>
