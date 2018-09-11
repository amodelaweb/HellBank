<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../../Objetos/Transaccion.php';
include_once '../../../config/Database.php';


$database = new Database();
$conn = $database->connection();
$transferencia_ext = new TransaccionExterna($conn) ;
$datos = json_decode(file_get_contents("php://input"));

if (is_numeric($datos->monto)) {
  $res = $transferencia_ext->RecibirTransferencia($datos->bancoOr,$datos->monto,$datos->idDest,$datos->tipoTrans, $datos->tipoProducto, $datos->tipoMoneda);
  
  if ($res['band'] == true ){
    http_response_code(200);
    echo json_encode(
      array('exito' => "Transaccion exitosa")
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


?>
