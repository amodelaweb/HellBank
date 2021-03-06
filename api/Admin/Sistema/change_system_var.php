<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
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

    $sistema_user = new Sistema(0, $conn) ;

    $datos = json_decode(file_get_contents("php://input"));

    if ($datos->fila == 'interes_aumento'){
      $resultado = $sistema_user->upDateInteresAhorros($datos->valor) ;
    }else if ($datos->fila == 'interes_inter_banco'){
      $resultado = $sistema_user->upDateInteresInterBanco($datos->valor) ;
    }else if ($datos->fila == 'cuota_manejo_default'){
      $resultado = $sistema_user->upDateCuota_Manejo($datos->valor) ;
    }else{
      $resultado = false ;
    }

    if ($resultado == true){
      http_response_code(200);
      echo json_encode(
        array('exito' => $datos->fila . " actualizado")
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
