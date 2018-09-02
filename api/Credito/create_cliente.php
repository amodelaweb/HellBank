<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

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

        $cuenta_ahorros = new CuentaAhorros($conn) ;

        $datos = json_decode(file_get_contents("php://input"));
        if (is_numeric($datos->saldo)) {
            if ($datos->saldo  >= 0) {
                $cuenta_ahorros->setIdDueno($my_token->getId());
                $cuenta_ahorros->setTasaInteres(0);
                $cuenta_ahorros->setSaldo($datos->saldo);

                $res = $cuenta_ahorros->create_ahorros() ;
                if ($res == "exito") {
                    http_response_code(201);
                    echo json_encode(
              array('Resultado' =>  $res)
            );
                } elseif ($res == "error") {
                    http_response_code(400);
                    echo json_encode(
              array('error' => "foreign error")
            );
                }
            } else {
                http_response_code(400);
                echo json_encode(array('error' => "monto debe ser positivo"));
            }
        }else {
            http_response_code(400);
            echo json_encode(array('error' => "monto debe ser numerico"));
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
