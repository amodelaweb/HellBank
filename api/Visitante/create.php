<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../Objetos/Visitante.php';
  include_once '../../config/Database.php';

  $database = new Database();
  $conn = $database->connection();

  $visitante_n = new Visitante($conn) ;

  $datos = json_decode(file_get_contents("php://input"));
  $datos->email = str_replace("%40","@",$datos->email);
  $visitante_n->setNombre($datos->nombre);
  $visitante_n->setApellido($datos->apellido);
  $visitante_n->setCedula($datos->cedula);
  $visitante_n->setEmail($datos->email);
  if ($datos->nombre != "" && $datos->apellido != ""){
    $res = $visitante_n->create_visitante() ;
  }else{
    $res = "Todos los campos son necesarios" ;
  }

  if($res == "exito") {
    http_response_code(201);
    echo json_encode(
      array('Resultado' =>  $res)
    );
  }else if ($res == "error"){
    http_response_code(400);
    echo json_encode(
      array('error' => "foreign error")
    );
  }else{
    $res = str_replace("SQLSTATE[23000]: Integrity constraint violation","",$res);
    $res = str_replace("for key","",$res);
    $res = str_replace("for key","",$res);
    $res = str_replace("1062","",$res);

    http_response_code(400);
    echo json_encode(
      array('error' => htmlspecialchars(strip_tags($res)))
    );
  }

?>
