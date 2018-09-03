<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../../Objetos/Credito.php';
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

    if ($datos->estado != "APROBADO" && $datos->estado != "NO_APROBADO" && $datos->estado != "EN_ESPERA"){
      http_response_code(400);
      die();
    }
    $credito_user = new Credito($conn) ;
    $resultado = $credito_user->upDateCredito($datos->id_credito, $datos->tasa_interes, $datos->interes_mora, $datos->estado) ;

    if ($resultado == true){
      http_response_code(200);
      echo json_encode(
        array('exito' => "Credito actualizado")
      );
    }else{
      http_response_code(400);
      echo json_encode(
        array('error' => "error")
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
