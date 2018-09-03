<?php
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../Objetos/TarjetaCredito.php';
  include_once '../../config/Database.php';
  include_once '../../config/AuthJson.php';

  $header = getallheaders() ;
  $token =  $header['x-api-key']  ;
  $my_token = new Token() ;
  $res = $my_token->decoding_key($token) ;

  if(isset($_GET['id']) ){
      $id_cuenta = $_GET['id'] ;
  }else{
    http_response_code(401);
    echo json_encode(array('mensaje' => 'Bad request'));
    die();
  }
  if ($res != false) {
      if (Token::is_valid_user($my_token)) {
          $database = new Database();
          $conn = $database->connection();
          $response_f = TarjetaCredito::get_single($id_cuenta,$conn);
          if ($response_f['band']) {
              http_response_code(200);
              echo json_encode($response_f['res']);
          } else {
              http_response_code(400);
              echo json_encode(array('mensaje' => 'No se encontraron tarjeta de credito.'));
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
