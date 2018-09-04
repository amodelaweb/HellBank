<?php
    class MensajeAdmin
    {

        private $connection ;

        public function __construct($conn)
        {
            $this->connection = $conn ;
        }
        public static function mostrarMensajesAd($conn)
        {
          try {
              $query = 'SELECT * FROM ' . '|' . ' WHERE id = :id_destino';
              $sql = $conn->prepare($query);
              $sql->bindParam(':id_destino', $id_destino);
              $sql->execute();
              $n = $sql->rowCount();
              if ($n > 0) {
                  $respuesta = array( );
                  $respuesta['mensajes'] = array( );
                  $fila = $sql->fetch(PDO::FETCH_ASSOC) ;
                  extract($fila);
                  $fila_r = array(
                      'id' => $id,
                      'contenido' => $contenido,
                      'id_origen' => $id_origen,
                      'id_destino' => $id_destino);
                  array_push($respuesta['mensajes'], $fila_r);

                  return array( 'band' => true , 'res' =>  $respuesta) ;
              } else {
                  return array( 'band' => false , 'res' => 'nul') ;
              }
          } catch (PDOException $e) {
              return array( 'band' => false , 'res' => 'nul') ;
          }
          return array( 'band' => false , 'res' => 'nul') ;
      }
