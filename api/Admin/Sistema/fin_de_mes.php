<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

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
    $datos = json_decode(file_get_contents("php://input"));
    $sistema_user = new Sistema(0, $conn) ;

    $resultado = $sistema_user->finMes($my_token->getId(),$datos->fecha) ;
    if ($resultado['band'] == true){
      http_response_code(200);
      echo json_encode(
        array('exito' => $resultado['msn'] )
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
