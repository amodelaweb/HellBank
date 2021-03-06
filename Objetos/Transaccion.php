<?php

/**
*
*/
include_once 'Consignacion.php';
include_once 'TarjetaCredito.php';


class TransaccionExterna
{

  private $connection ;

  function __construct($conn)
  {
    $this->connection = $conn ;
  }

  public static function get_user_transacciones($conn, $user_id)
  {
    $con = $conn;
    $sql1 = 'SELECT * FROM cuenta_ahorros WHERE id_dueno='.$user_id;
    if ($con->query($sql1)->rowCount() != 0) {
      $cAhorros = array();
      foreach ($con->query($sql1) as $fila) {
        array_push($cAhorros, $fila['id']);
      }
    }
    if (!empty($cAhorros)) {
      $movCAhorrosTrans = array();
      for ($i=0; $i < count($cAhorros); $i++) {
        $sql2 = 'SELECT * FROM transferencias_externas WHERE id_origen='.$cAhorros[$i];
        if($con->query($sql2)->rowCount() != 0){
          foreach ($con->query($sql2) as $fila) {
            array_push($movCAhorrosTrans,array($fila['banco_origen'],$fila['banco_destino'],$fila['id_origen'],$fila['monto'],$fila['id_destino'],$fila['fecha_realizado'],$fila['tipo_trans']));
          }
        }
      }
      if (!empty($movCAhorrosTrans)) {
        $respuesta = array();
        $respuesta['transacciones_ext'] = array();
        foreach ($movCAhorrosTrans as $elm) {
          $cat_item = array(
            'banco_origen' => $elm[0],
            'banco_destino' => $elm[1],
            'id_origen' => $elm[2],
            'id_destino' => $elm[4],
            'monto' => $elm[3],
            'fecha' => $elm[5]
          );
          array_push($respuesta['transacciones_ext'], $cat_item);
        }
        return array( "band" => true , "msn" => $respuesta);
      }
      return array( "band" => false , "msn" => 'No tiene Transacciones Externas');
    } else {
      return array( "band" => false , "msn" => "No posee cuentas de ahorro actualmente");
    }
  }
  public function EnviarTransferencia($bancoDest,$idOrigen,$monto,$idDest,$tipoTrans, $n_cuotas, $tipoMoneda){
    if ($monto < 0){
      return array ("band" => false, "msn" => "Error Monto debe ser mayor a 0") ;
    }
    try{
      $con = $this->connection;
      $bancoOr = "HellBank" ;
      $sql0 = 'INSERT INTO transferencias_externas(banco_origen,banco_destino,id_origen,monto,id_destino,fecha_realizado,tipo_trans)
      VALUES("'.$bancoOr.'","'.$bancoDest.'",'.$idOrigen.','.$monto.','.$idDest.',NOW(),"'.$tipoTrans.'")';
      $con->query($sql0);
    }catch (PDOException $e) {
      return array( 'band' => false , 'res ' => $e) ;
    }
    if ($tipoTrans == "compra_credito"){
      $t_credito = new TarjetaCredito($this->connection) ;
      return $t_credito->comprar($idOrigen, $n_cuotas, $monto, $tipoMoneda);
    }elseif ($tipoTrans == "ahorros"){
      $user_consignacion =new Consignacion ($this->connection);
      return $user_consignacion->BancoExtConsignar2($idOrigen,$monto, $tipoMoneda) ;
    }
    return array ("band" => false, "msn" => "Error En la trnasferencia") ;
  }
  public function RecibirTransferencia($bancoOr,$monto,$idDest,$tipoTrans, $tipoProducto, $tipoMoneda){
    if ($monto < 0){
      return array ("band" => false, "msn" => "Error Monto debe ser mayor a 0") ;
    }
    try{
      $con = $this->connection ;
      $idOrigen = 0 ;
      $bancoDest = "HellBank" ;
      $sql0 = 'INSERT INTO transferencias_externas(banco_origen,banco_destino,id_origen,monto,id_destino,fecha_realizado,tipo_trans)
      VALUES("'.$bancoOr.'","'.$bancoDest.'",'.$idOrigen.','.$monto.','.$idDest.',NOW(),"'.$tipoTrans.'")';
      $con->query($sql0);
    }catch (PDOException $e) {
      return array( 'band' => false , 'res ' => $e) ;
    }
    if ($tipoTrans == "ahorros"){
      $consignacion = new Consignacion ($this->connection) ;
      return $consignacion->BancoExtConsignar($tipoProducto, $idDest, $monto, $tipoMoneda);
    }
    return array ("band" => false, "msn" => "Error En la trnasferencia") ;
  }

}


?>
