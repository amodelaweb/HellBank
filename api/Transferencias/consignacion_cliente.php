<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../Objetos/Consignacion.php';
include_once '../../config/Database.php';
include_once '../../config/AuthJson.php';

$header = getallheaders() ;
$token =  $header['x-api-key']  ;
$my_token = new Token() ;
$res = $my_token->decoding_key($token) ;
if ($res) {
    if (Token::is_valid_user($my_token)) {
        $database = new Database();
        $conn = $database->connection();

        $consignacion_user = new Consignacion($conn) ;

        $datos = json_decode(file_get_contents("php://input"));

        if (is_numeric($datos->monto)) {

            $res = $consignacion_user->ClienteConsignar($datos->producto_origen, $datos->tipo_destino, $datos->producto_destino, $datos->monto, $datos->tipo_moneda);
            if ($res['band'] == true ){
              http_response_code(200);
              echo json_encode(
              array('exito' => "Consignacion exitosa")
              );
            }else{
              http_response_code(400);
              echo json_encode(
              array('error' => $res['msn'])
              );
            }
        } else {
          http_response_code(400);
          echo json_encode(
          array('error' => "monto debe ser numerico")
          );
        }
    } else {
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
