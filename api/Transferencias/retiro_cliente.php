<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../Objetos/Retiro.php';
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

        $retiro_user = new Retiro($conn) ;

        $datos = json_decode(file_get_contents("php://input"));
        if (is_numeric($datos->monto)) {
            $res = $retiro_user->retirar($datos->id_origen,$datos->monto);
            if ($res['band'] == true ){
              http_response_code(200);
              echo json_encode(
              array('exito' => "Retiro exitoso")
              );
            }else{
              http_response_code(200);
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
