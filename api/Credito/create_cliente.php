<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../Objetos/Credito.php';
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

        $credito_usuario = new Credito($conn) ;

        $datos = json_decode(file_get_contents("php://input"));
        if (is_numeric($datos->monto) && is_numeric($datos->tasa_interes)) {
            if ($datos->monto  >= 0 && $datos->tasa_interes  > 0) {
                $credito_usuario->setDueno($my_token->getId());
                $credito_usuario->setMonto($datos->monto);
                $credito_usuario->setTasaInteres($datos->tasa_interes);

                $res = $credito_usuario->create_credito_user() ;
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
                echo json_encode(array('error' => "monto y tasa deben ser positivo"));
            }
        }else {
            http_response_code(400);
            echo json_encode(array('error' => "monto y tasa deben ser numerico"));
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
