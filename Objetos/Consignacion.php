<?php
class Consignacion
{
  private $id;
  private $idDestino;
  private $monto;
  private $fecha;
  private $moneda;
  private $connection ;

  public function __construct($conn)
  {
    $this->connection = $conn ;
  }

  public function ClienteConsignar($idProductoOrigen, $tipoProducto, $idProductoDestino, $monto, $tipoMoneda)
  {
    $con = $this->connection ;
    $sql1 = 'SELECT * FROM cuenta_ahorros WHERE id = '.$idProductoOrigen;
    if (!empty($con->query($sql1))) {
      if ($tipoProducto == "ahorros") {
        $sql2 = 'SELECT * FROM cuenta_ahorros WHERE id = '.$idProductoDestino;
        if ($con->query($sql2)->rowCount() != 0) {
          if ($tipoMoneda == "pesos") {
            $monto = $monto/1000;
          }
          foreach ($con->query($sql1) as $res1) {
            $idDuenoOr = $res1['id_dueno'];
            $res1 = $res1['saldo'];
          }
          $montoOrigen = $res1-$monto;
          foreach ($con->query($sql2) as $res2) {
            $idDuenoDes = $res2['id_dueno'];
            $res2 = $res2['saldo'];
          }
          $montoDestino = $res2+$monto;
          if ($res1 >= $monto) {
            $sql3 = 'UPDATE cuenta_ahorros SET saldo ='.$montoOrigen.' WHERE id = '.$idProductoOrigen;
            $sql4 = 'UPDATE cuenta_ahorros SET saldo ='.$montoDestino.' WHERE id = '.$idProductoDestino;
            $sql5 = 'INSERT INTO consignacion_debito (id_origen,id_destino, monto, fecha_realizado) VALUES ('.$idProductoOrigen.','.$idProductoDestino.','.$monto.',NOW())';
            $sql6 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$idDuenoOr.','.$idDuenoDes.',"Se ha hecho una consignación por '.$monto.'")';
            $con->query($sql3);
            $con->query($sql4);
            $con->query($sql5);
            $con->query($sql6);
            return array( 'band' => true , "msn" =>  "Consignación Realizada") ;
          } else {
            return array( 'band' => false , "msn" =>  "No hay fondos suficientes") ;
          }
        } else {
          return array( 'band' => false , "msn" =>  "No existe cuenta de ahorros de destino") ;
        }
      } elseif ($tipoProducto == "credito") {
        $sql2 = 'SELECT * FROM credito WHERE id = '.$idProductoDestino;
        if ($con->query($sql2)->rowCount() != 0) {
          if ($tipoMoneda == "pesos") {
            $monto = $monto/1000;
          }
          foreach ($con->query($sql1) as $res1) {
            $idDuenoOr = $res1['id_dueno'];
            $res1 = $res1['saldo'];
          }
          $montoOrigen = $res1-$monto;
          foreach ($con->query($sql2) as $res2) {
            $idDuenoDes = $res2['id_dueno'];
            $res2 = $res2['monto'];
          }
          if ($res2 != 0) {
            $montoDestino = $res2-$monto;
            if ($res1 >= $monto) {
              if ($montoDestino != 0) {
                $montoOrigen += $montoDestino;
              }
              $sql3 = 'UPDATE cuenta_ahorros SET saldo ='.$montoOrigen.' WHERE id = '.$idProductoOrigen;
              $sql4 = 'UPDATE credito SET monto ='.$montoDestino.', ultimo_pago= NOW() WHERE id = '.$idProductoDestino;
              $sql5 = 'INSERT INTO consignacion_credito (id_origen,id_destino, monto, fecha_realizado) VALUES ('.$idProductoOrigen.','.$idProductoDestino.','.$monto.',NOW())';
              $sql6 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$idDuenoOr.','.$idDuenoDes.',"Se ha hecho una consignación por '.$monto.'")';
              $con->query($sql3);
              $con->query($sql4);
              $con->query($sql5);
              $con->query($sql6);
              return array( 'band' => true , "msn" =>  "Consignación Realizada") ;
            } else {
              return array( 'band' => false , "msn" =>  "No hay fondos suficientes") ;
            }
          } else {
            return array( 'band' => false , "msn" =>  "No se puede hacer la consignación porque el crédito se encuentra en 0 javecoins.") ;
          }
        } else {
          return array( 'band' => false , "msn" =>  "No existe crédito de destino") ;
        }
      }
    } else {
      return array( 'band' => false , "msn" =>  "Producto de origen no encontrado") ;
    }
    return array ( "band" => false , "msn" =>  "Unexpected error" ) ;
  }

  public function VisitanteConsignar($tipoProducto, $idProductoDestino, $monto, $tipoMoneda, $cedula)
  {

    $con = $this->connection ;

    if ($tipoProducto == "ahorros"){
      $sql2 = 'SELECT * FROM cuenta_ahorros WHERE id = '.$idProductoDestino;
      if($con->query($sql2)->rowCount() != 0){
        if ($tipoMoneda == "pesos"){
          $monto = $monto/1000;
        }
        foreach ($con->query($sql2) as $res2) {
          $idDuenoOr = $res2['id_dueno'];
          $res2 = $res2['saldo'];
        }
        $montoDestino = $res2+$monto;
        $sql4 = 'UPDATE cuenta_ahorros SET saldo ='.$montoDestino.' WHERE id = '.$idProductoDestino;
        $sql5 = 'INSERT INTO consignacion_debito (id_origen,id_destino, monto, fecha_realizado) VALUES ('.$cedula.','.$idProductoDestino.','.$monto.',NOW())';
        $sql6 = 'INSERT INTO mensajes(id_origen,id_destino,contenido) VALUES('.$cedula.','.$idDuenoOr.',"Se ha hecho una consignación por '.$monto.'")';
        $con->query($sql4);
        $con->query($sql5);
        $con->query($sql6);
        return array ( "band" => true , "msn" =>  "Consignación Realizada" );
      }else{
        return array ( "band" => false , "msn" =>  "No existe cuenta de ahorros de destino" );
      }
    }elseif($tipoProducto == "credito"){
      $sql2 = 'SELECT * FROM credito WHERE id = '.$idProductoDestino;
      if($con->query($sql2)->rowCount() != 0){
        if ($tipoMoneda == "pesos"){
          $monto = $monto/1000;
        }
        foreach ($con->query($sql2) as $res2) {
          $idDuenoOr = $res2['id_dueno'];
          $res2 = $res2['monto'];
        }
        if($res2 != 0){
          $montoDestino = $res2-$monto;
          if($montoDestino != 0)
          $monto += $montoDestino;
        }
        $sql4 = 'UPDATE credito SET monto ='.$montoDestino.', ultimo_pago= NOW() WHERE id = '.$idProductoDestino;
        $sql5 = 'INSERT INTO consignacion_credito (id_origen,id_destino, monto, fecha_realizado) VALUES ('.$cedula.','.$idProductoDestino.','.$monto.',NOW())';
        $sql6 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$cedula.','.$idDuenoOr.',"Se ha hecho una consignación por '.$monto.'")';
        $con->query($sql4);
        $con->query($sql5);
        $con->query($sql6);
        return array ( "band" => true , "msn" =>  "Consignación Realizada" . " Sobran ".intval($monto-$montoDestino));
      }else{
        return array ( "band" => false , "msn" =>  "No se puede hacer la consignación porque el crédito se encuentra en 0 javecoins." );
      }
    }else{
      return array ( "band" => false , "msn" =>  "No existe crédito de destino" );
    }
  }

  public function BancoExtConsignar($tipoProducto, $idProductoDestino, $monto, $tipoMoneda)
  {

    $con = $this->connection ;

    if ($tipoProducto == "ahorros"){
      $sql2 = 'SELECT * FROM cuenta_ahorros WHERE id = '.$idProductoDestino;
      if($con->query($sql2)->rowCount() != 0){
        if ($tipoMoneda == "pesos"){
          $monto = $monto/1000;
        }
        foreach ($con->query($sql2) as $res2) {
          $idDuenoOr = $res2['id_dueno'];
          $res2 = $res2['saldo'];
        }
        $montoDestino = $res2+$monto;
        $sql4 = 'UPDATE cuenta_ahorros SET saldo ='.$montoDestino.' WHERE id = '.$idProductoDestino;
        $sql6 = 'INSERT INTO mensajes(id_origen,id_destino,contenido) VALUES("0",'.$idDuenoOr.',"Se ha hecho una consignación por '.$monto.'")';
        $con->query($sql4);
        $con->query($sql6);
        return array ( "band" => true , "msn" =>  "Consignación Realizada" );
      }else{
        return array ( "band" => false , "msn" =>  "No existe cuenta de ahorros de destino" );
      }
    }elseif($tipoProducto == "credito"){
      $sql2 = 'SELECT * FROM credito WHERE id = '.$idProductoDestino;
      if($con->query($sql2)->rowCount() != 0){
        if ($tipoMoneda == "pesos"){
          $monto = $monto/1000;
        }
        foreach ($con->query($sql2) as $res2) {
          $idDuenoOr = $res2['id_dueno'];
          $res2 = $res2['monto'];
        }
        if($res2 != 0){
          $montoDestino = $res2-$monto;
          if($montoDestino != 0)
          $monto += $montoDestino;
        }
        $sql4 = 'UPDATE credito SET monto ='.$montoDestino.', ultimo_pago= NOW() WHERE id = '.$idProductoDestino;
        $sql6 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES("0",'.$idDuenoOr.',"Se ha hecho una consignación por '.$monto.'")';
        $con->query($sql4);
        $con->query($sql6);
        return array ( "band" => true , "msn" =>  "Consignación Realizada" . " Sobran ".intval($monto-$montoDestino));
      }else{
        return array ( "band" => false , "msn" =>  "No se puede hacer la consignación porque el crédito se encuentra en 0 javecoins." );
      }
    }else{
      return array ( "band" => false , "msn" =>  "No existe crédito de destino" );
    }
  }

  public function BancoExtConsignar2($idProductoOrigen,$monto, $tipoMoneda)
  {
    $con = $this->connection ;
    $sql1 = 'SELECT * FROM cuenta_ahorros WHERE id = '.$idProductoOrigen;
    if (!empty($con->query($sql1))) {

          if ($tipoMoneda == "pesos") {
            $monto = $monto/1000;
          }
          foreach ($con->query($sql1) as $res1) {
            $idDuenoOr = $res1['id_dueno'];
            $res1 = $res1['saldo'];
          }
          $montoOrigen = $res1-$monto;
          
          if ($res1 >= $monto) {
            $sql3 = 'UPDATE cuenta_ahorros SET saldo ='.$montoOrigen.' WHERE id = '.$idProductoOrigen;
            $con->query($sql3);
            return array( 'band' => true , "msn" =>  "Consignación Realizada") ;
          } else {
            return array( 'band' => false , "msn" =>  "No hay fondos suficientes") ;
          }

    } else {
      return array( 'band' => false , "msn" =>  "Producto de origen no encontrado") ;
    }
    return array ( "band" => false , "msn" =>  "Unexpected error" ) ;
  }

  public static function get_user_consignaciones($conn, $user_id)
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
      $movCAhorrosCon = array();

      for ($i=0; $i < count($cAhorros); $i++) {
        $sql2 = 'SELECT * FROM consignacion_debito WHERE id_destino='.$cAhorros[$i].' OR id_origen='.$cAhorros[$i];
        if($con->query($sql2)->rowCount() != 0){
          foreach ($con->query($sql2) as $fila) {
            array_push($movCAhorrosCon,array($fila['id_destino'],$fila['id_origen'],$fila['monto'],$fila['fecha_realizado']));
          }
        }
      }
      if (!empty($movCAhorrosCon)) {
        $respuesta = array();
        $respuesta['consignaciones'] = array();
        foreach ($movCAhorrosCon as $elm) {
          $cat_item = array(
            'id_origen' => $elm[0],
            'id_destino' => $elm[1],
            'monto' => $elm[2],
            'fecha' => $elm[3]
          );
          array_push($respuesta['consignaciones'], $cat_item);
        }
        return array( "band" => true , "msn" => $respuesta);
      }
      return array( "band" => false , "msn" => 'No tiene consignaciones');
    } else {
      return array( "band" => false , "msn" => "No posee cuentas de ahorro actualmente");
    }
  }

  public static function get_user_consignaciones_credito($conn, $user_id)
  {
    $con = $conn;
    $sql1 = 'SELECT * FROM credito WHERE id_dueno='.$user_id;
    if($con->query($sql1)->rowCount() != 0){
        $creditos = array();
        foreach ($con->query($sql1) as $fila) {
            array_push($creditos,$fila['id']);
        }
    }
    if (!empty($creditos)) {
      $movCreditos = array();
      for ($i=0; $i < count($creditos); $i++) {
          //Verificar tabla consignacion_credito
          $sql2 = 'SELECT * FROM consignacion_credito WHERE id_destino='.$creditos[$i];
          if($con->query($sql2)->rowCount() != 0){
              foreach ($con->query($sql2) as $fila) {
                  array_push($movCreditos,array($fila['id_destino'],$fila['id_origen'],$fila['monto'],$fila['fecha_realizado']));
              }
          }
      }
      if (!empty($movCreditos)) {
        $respuesta = array();
        $respuesta['consignaciones'] = array();
        foreach ($movCreditos as $elm) {
          $cat_item = array(
            'id_destino' => $elm[0],
            'id_origen' => $elm[1],
            'monto' => $elm[2],
            'fecha' => $elm[3]
          );
          array_push($respuesta['consignaciones'], $cat_item);
        }
        return array( "band" => true , "msn" => $respuesta);
      }
      return array( "band" => false , "msn" => 'No tiene consignaciones');
    } else {
      return array( "band" => false , "msn" => "No posee creditos actualmente");
    }
  }

}
