<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../../Objetos/TarjetaCredito.php';
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

    $tarjeta_user = new TarjetaCredito($conn) ;
    $resultado = $tarjeta_user->upDateTarjetaCredito($datos->id_tarjeta_credito, $datos->id_ahorros, $datos->cupo_maximo ,$datos->sobre_cupo , $datos->tasa_interes, $datos->cuota_manejo ,  $datos->estado);

    if ($resultado == true){
      http_response_code(200);
      echo json_encode(
        array('exito' => "Tarjeta Credito actualizado")
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
