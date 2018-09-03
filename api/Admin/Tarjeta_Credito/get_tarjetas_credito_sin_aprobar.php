<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../../Objetos/TarjetaCredito.php';
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

      $response_f = TarjetaCredito::getUnaproved_Tarjetas($conn);
      if( $response_f['band'] ){
        http_response_code(200);
        echo json_encode($response_f['res']);
      }else{
        http_response_code(400);
        echo json_encode(
          array('mensaje' => 'No se encontraron tarjetas de credito.')
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
