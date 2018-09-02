<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../Objetos/TarjetaCredito.php';
include_once '../../Objetos/CuentaAhorros.php';
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

        $tarjeta_cliente = new TarjetaCredito($conn) ;
        $datos = json_decode(file_get_contents("php://input"));

        if (CuentaAhorros::exist_cuenta($datos->cuenta_ahorros, $conn)) {
            $tarjeta_cliente->setIdAhorros($datos->cuenta_ahorros);
            $tarjeta_cliente->setIdDueno($my_token->getId()) ;
            $res = $tarjeta_cliente->create_tarjeta() ;
            
            if ($res == "exito") {
                http_response_code(201);
                echo json_encode(
              array('resultado' =>  $res)
            );
            } elseif ($res == "error") {
                http_response_code(400);
                echo json_encode(
              array('error' => "foreign error")
            );
            }
        } else {
            http_response_code(400);
            echo json_encode(array('error' => "No existe cuenta de ahorros"));
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
