<?php
class Retiro
{
  private $id;
  private $idCuenta;
  private $monto;
  private $fecha;
  private $connection ;

  public function __construct($conn)
  {
    $this->connection = $conn ;
  }

  public function retirar($idProdOrigen, $cantRetirar)
  {
    $con = $this->connection ;
    $sql1 = 'SELECT * FROM cuenta_ahorros WHERE id = '.$idProdOrigen;
    if (!empty($con->query($sql1))) {
      foreach ($con->query($sql1) as $res1) {
        $res = $res1['saldo'];
        $idCA = $res1['id'];
        $idDuenoOr = $res1['id_dueno'];
      }
      $montoOrigen = $res-$cantRetirar;
      if ($res >= $cantRetirar) {
        $sql3 = 'UPDATE cuenta_ahorros SET saldo ='.$montoOrigen.' WHERE id = '.$idProdOrigen;
        $sql4 = 'INSERT INTO retiro (id_ahorros,monto,fecha_realizado) VALUES('.$idCA.','.$cantRetirar.',NOW())';
        $sql5 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$idDuenoOr.','.$idDuenoOr.',"Se ha hecho un retiro por '.$cantRetirar.'")';
        $con->query($sql3);
        $con->query($sql4);
        $con->query($sql5);
        return array("band" => true , "msn" => "Retiro Realizado");
      } else {
        return array("band" => false , "msn" => "No hay fondos suficientes");
      }
    } else {
      return array("band" => false , "msn" => "Producto de origen no existe");
    }
  }

  public static function get_user_retiros($conn, $user_id)
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
      $movCAhorrosRet = array();
      for ($i=0; $i < count($cAhorros); $i++) {
        $sql2 = 'SELECT * FROM retiro WHERE id_ahorros='.$cAhorros[$i];
        if ($con->query($sql2)->rowCount() != 0) {
          foreach ($con->query($sql2) as $fila) {
            array_push($movCAhorrosRet, array($fila['id_ahorros'],$fila['monto'],$fila['fecha_realizado']));
          }
        }
      }
      if (!empty($movCAhorrosRet)) {
        $respuesta = array();
        $respuesta['retiros'] = array();
        foreach ($movCAhorrosRet as $elm) {
          $cat_item = array(
            'id_producto' => $elm[0],
            'monto' => $elm[1],
            'fecha' => $elm[2],
          );
          array_push($respuesta['retiros'], $cat_item);
        }
        return array( "band" => true , "msn" => $respuesta);
      }
      return array( "band" => false , "msn" => 'No tiene retiros');
    } else {
      return array( "band" => false , "msn" => "No posee cuentas de ahorro actualmente");
    }
  }
}
