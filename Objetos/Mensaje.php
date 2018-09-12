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
      $query = 'SELECT * FROM mensajes WHERE id_destino='.$id_user.' OR id_origen='.$id_user;
      $sql = $connx->prepare($query);
      $sql->bindParam(':id_dueno', $id_user);
      $sql->execute();
      $n = $sql->rowCount();
      if ($n > 0) {
        $respuesta = array();
        $respuesta['mensajes'] = array();
        while ($fila = $sql->fetch(PDO::FETCH_ASSOC)) {
          extract($fila);
          $cat_item = array(
            'id_origen' => $id_origen,
            'id_destino' => $id_destino,
            'contenido' => $contenido
          );
          array_push($respuesta['mensajes'], $cat_item);
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
