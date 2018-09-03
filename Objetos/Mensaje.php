<?php
class Mensaje{
  private $idCliente;
  private $idAdmin;
  private $mensaje;
  private $id ;
  private $connection ;
  function __construct($conn){
    $this->connection = $conn ;
  }

  public static function getUser_mensajes($id_user, $connx)
  {
    try {
      $query = 'SELECT * FROM ' . 'credito' . ' WHERE id_dueno = :id_dueno';
      $sql = $connx->prepare($query);
      $estado = 'APROBADO';
      $sql->bindParam(':id_dueno', $id_user);
      $sql->execute();
      $n = $sql->rowCount();
      if ($n > 0) {
        $respuesta = array();
        $respuesta['creditos'] = array();
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
          extract($fila);
          $cat_item = array(
            'id' => $id,
            'estado' => $estado,
            'saldo' => $saldo,
            'tasa_interes' => $tasa_interes,
            'interes_mora' => $interes_mora,
            'monto' => $monto,
            'fecha_creado' => $fecha_creado,
            'ultimo_pago' => $ultimo_pago,
            'email_vis' => $email_vis

          );
          array_push($respuesta['creditos'], $cat_item);
        }

        return array( 'band' => true , 'res' =>  $respuesta) ;
      } else {
        return array( 'band' => false , 'res' => 'nul') ;
      }
    } catch (PDOException $e) {
      return array( 'band' => false , 'res' => 'nul') ;
    }
    return array( 'band' => false , 'res' => 'nul') ;
  }
}

?>
