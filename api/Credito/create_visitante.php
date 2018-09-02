<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../Objetos/Credito.php';
include_once '../../Objetos/Visitante.php';
include_once '../../config/Database.php';
include_once '../../config/AuthJson.php';

$database = new Database();
$conn = $database->connection();
$visitante_n = new Visitante($conn) ;

$datos = json_decode(file_get_contents("php://input"));

$visitante_n->setEmail($datos->email) ;
$res = $visitante_n->exist_visitante() ;

if ($res == "success") {
    $creditovisitante = new Credito($conn) ;
    if (is_numeric($datos->monto) && is_numeric($datos->tasa_interes)) {
        if ($datos->monto  >= 0 && $datos->tasa_interes  > 0) {
            $creditovisitante->setEmailVis($visitante_n->getEmail()) ;
            $creditovisitante->setMonto($datos->monto);
            $creditovisitante->setTasaInteres($datos->tasa_interes);

            $res2 = $creditovisitante->create_credito_visitante() ;
            if ($res2 == "exito") {
                http_response_code(201);
                echo json_encode(
                  array('Resultado' =>  "exito")
                );
            } elseif ($res == "error") {
                http_response_code(400);
                echo json_encode(
        array('error' => "foreign error")
      );
            } else {
                http_response_code(400);
                echo json_encode(array('error' => "monto y tasa deben ser positivo"));
            }
        } else {
            http_response_code(400);
            echo json_encode(array('error' => "monto y tasa deben ser positivo"));
        }
    } else {
        http_response_code(400);
        echo json_encode(array('error' => "monto y tasa deben ser numerico"));
    }
} else {
    http_response_code(400);
    echo json_encode(array('error' => "no_existe_visitante"));
}
