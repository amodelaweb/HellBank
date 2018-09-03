<?php

/**
*
*/
class ComprasTarjeta
{

  private $connection ;

  function __construct($conn)
  {
    $this->connection = $conn;
  }

  public static function get_user_compras($conn, $user_id)
  {
    $con = $conn;
    $sql1 = 'SELECT * FROM tarjeta_credito WHERE id_dueno='.$user_id;
    if($con->query($sql1)->rowCount() != 0){
      $tCredito = array();
      foreach ($con->query($sql1) as $fila) {
        array_push($tCredito,$fila['id']);
      }
    }
    if (!empty($tCredito)) {
      $movTarCredito = array();
      for ($i=0; $i < count($tCredito); $i++) {
          //Verificar tabla compra_credito
          $sql2 = 'SELECT * FROM compra_credito WHERE id_producto='.$tCredito[$i];
          if($con->query($sql2)->rowCount() != 0){
              foreach ($con->query($sql2) as $fila) {
                  array_push($movTarCredito,array($fila['id_producto'],$fila['monto'],$fila['fecha_realizado'],$fila['numero_cuotas']));
              }
          }
      }
      if (!empty($movTarCredito)) {
        $respuesta = array();
        $respuesta['compras_t'] = array();
        foreach ($movTarCredito as $elm) {
          $cat_item = array(
            'id_producto' => $elm[0],
            'monto' => $elm[1],
            'fecha' => $elm[2],
            'cuotas' => $elm[3]
          );
          array_push($respuesta['compras_t'], $cat_item);
        }
        return array( "band" => true , "msn" => $respuesta);
      }
      return array( "band" => false , "msn" => 'No tiene compras con tarjeta');
    } else {
      return array( "band" => false , "msn" => "No posee tarjetas de credito");
    }
  }

}


?>
