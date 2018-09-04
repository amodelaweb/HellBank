<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../../Objetos/Sistema.php';
include_once '../../../config/Database.php';
include_once '../../../config/AuthJson.php';

$header = getallheaders() ;
$token =  $header['x-api-key']  ;
$my_token = new Token() ;
$res = $my_token->decoding_key($token) ;
if ($res) {
  if (Token::is_valid_admin($my_token)) {
    $database = new Database();
    $conn = $database->connection();

    $sistema_user = new Sistema(0, $conn) ;
    $resultado = $sistema_user->finMes() ;
    if ($resultado['band'] == true){
      http_response_code(200);
      echo json_encode(
        array('exito' => "Fin de mes correcto")
      );
    }else{
      http_response_code(400);
      echo json_encode(
        array('error' => $resultado['msn'])
      );
    }

  }else{
    http_response_code(400);
    echo json_encode(
      array('error' => "error")
    );
  }
} else {
  http_response_code(400);
  echo json_encode(
    array('error' => "error")
  );
}
?>
