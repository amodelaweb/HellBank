<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../Objetos/Visitante.php';
include_once '../../Objetos/Consignacion.php';
include_once '../../config/Database.php';

$database = new Database();
$conn = $database->connection();

$visitante_n = new Visitante($conn) ;
$datos = json_decode(file_get_contents("php://input"));
$datos->email = str_replace("%40","@",$datos->email);
$visitante_n->setEmail($datos->email) ;
$res = $visitante_n->exist_visitante() ;
$cedula_vis = $visitante_n->getId() ;

if ($res == "success") {

  $database2 = new Database();
  $conn2 = $database2->connection();

  $consignacion_user = new Consignacion($conn2) ;

  if (is_numeric($datos->monto)) {

    $res2 = $consignacion_user->VisitanteConsignar($datos->tipo_destino, $datos->producto_destino, $datos->monto, $datos->tipo_moneda, $cedula_vis);

    if ($res2['band'] == true ){
      http_response_code(200);
      echo json_encode(
        array('exito' => "Consignacion exitosa")
      );
    }else{
      http_response_code(200);
      echo json_encode(
        array('error' => $res['msn'])
      );
    }
  } else {
    http_response_code(400);
    echo json_encode(array('error' => "no_existe_visitante"));
  }

}
