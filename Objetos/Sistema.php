<?php
include_once dirname(__FILE__) . '/Usuario.php';
include_once dirname(__FILE__) . '/ManejoCorreo.php';

class Sistema{
  private $connection ;
  private $interes;
  private $usuarios = [];
  private $mailer;

  function __construct($interes, $conn){
    $this->interes = $interes;
    $this->connection = $conn ;
  }
  function addUsuario($usuario){
    array_push($this->usuarios,$usuario);
  }
  function enviarMail($username,$correo,$asunto,$mensaje){
    $this->mailer = new ManejoCorreo($correo,$asunto,$mensaje);
    $this->mailer->enviarMail($username);
  }
  public function upDateInteresAhorros($value)
  {
    $query = 'UPDATE ' . 'sistema' . '
    SET interes_aumento = :interes_aumento
    WHERE id = :id';

    $stmt = $this->connection->prepare($query);

    $value = htmlspecialchars(strip_tags($value));
    $id = 1 ;

    $stmt->bindParam(':interes_aumento', $value);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()) {
      return true;
    }

    return false;
  }
  public function upDateInteresInterBanco($value)
  {
    $query = 'UPDATE ' . 'sistema' . '
    SET interes_inter_banco = :interes_inter_banco
    WHERE id = :id';

    $stmt = $this->connection->prepare($query);

    $value = htmlspecialchars(strip_tags($value));
    $id = 1 ;

    $stmt->bindParam(':interes_inter_banco', $value);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()) {
      return true;
    }

    return false;
  }
  public function upDateCuota_Manejo($value)
  {
    $query = 'UPDATE ' . 'sistema' . '
    SET cuota_manejo_default = :cuota_manejo_default
    WHERE id = :id';

    $stmt = $this->connection->prepare($query);

    $value = htmlspecialchars(strip_tags($value));
    $id = 1 ;

    $stmt->bindParam(':cuota_manejo_default', $value);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()) {
      return true;
    }

    return false;
  }

  public function finMes($fecha,$idAdmin)
  {
    $mes = strftime("%m",strtotime($fecha));
    $fecha = strftime("%d-%m-%Y",strtotime($fecha));
    CobrarCreditos($idAdmin,$fecha);
    CobrarTarjetasCredito($mes);
    AumentarSaldoCA();
    CobrarCuotaManejoTarjetas();
    return array("band" => false , "msn" => "Foreign error") ;
  }

  private function CobrarCreditos($idAdmin, $fechaActual){
    $con =$this->connection->connection();
    //Cliente
    $sql0 = 'SELECT * FROM credito WHERE email_vis = "N/A"';
    if($con->query($sql0)->rowCount() != 0){
        foreach ($con->query($sql0) as $fila) {
            $monto = $fila['monto'];
            $idDueno = $fila['id_dueno'];
            $idCredito = $fila['id'];
            
            $pago = $monto;
            $con->beginTransaction();
            $sql1 = 'SELECT * FROM cuenta_ahorros WHERE id_dueno='.$idDueno.' ORDER BY saldo DESC';
            foreach($con->query($sql1) as $cuenta){
                if($pago <= $cuenta['saldo'] && $pago!=0){
                    $sql2 = 'UPDATE cuenta_ahorros SET saldo='.intval($cuenta['saldo']-$pago).' WHERE id='.$cuenta['id'];
                    $sql3 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$idAdmin.','.$idDueno.',"Se ha descontado de la cuenta de ahorros para pagar el credito de '.$monto.'.")';
                    $sql4 = 'INSERT INTO movimientos_admin (id_admin,id_producto,id_operacion,fecha_realizado) VALUES('.$idAdmin.','.$idCredito.',6,NOW())';
                    $con->exec($sql2);
                    $con->exec($sql3);
                    $con->exec($sql4);
                    $pago = 0;
                }elseif($pago > $cuenta['saldo']){
                    $sql2 = 'UPDATE cuenta_ahorros SET saldo='.intval($pago-$cuenta['saldo']).' WHERE id='.$cuenta['id'];
                    $sql3 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$idAdmin.','.$idDueno.',"Se ha descontado de la cuenta de ahorros para pagar el credito de '.$monto.'.")';
                    $sql4 = 'INSERT INTO movimientos_admin (id_admin,id_producto,id_operacion,fecha_realizado) VALUES('.$idAdmin.','.$idCredito.',6,NOW())';
                    $con->exec($sql2);
                    $con->exec($sql3);
                    $con->exec($sql4);
                    $pago = $pago - $cuenta['saldo'];
                }else{
                    break;
                }
            }
            if($pago != 0){
                $con->rollBack();
            }else{
                $con->commit();
                $sql5 = 'UPDATE credito SET monto=0, ultimo_pago=NOW() WHERE id='.$idCredito;
                $con->query($sql5);
            }
        }
    }
    //Visitante
    $sql0 = 'SELECT * FROM credito WHERE email_vis != "N/A"';
    if($con->query($sql0)->rowCount() != 0){
        foreach ($con->query($sql0) as $fila) {
            $monto = $fila['monto'];
            $email = $fila['email_vis'];
            $idCredito = $fila['id'];
            $fechaCreado = $fila['fecha_creado'];
            $interesMora = $fila['interes_mora'];
            $fechaCreado = strtotime($fechaCreado);
            $mesCreado = date("m",$fechaCreado);
            $mesActual = date("m",strtotime($fechaActual));
            $diaCreado = date("d",$fechaCreado);
            $diaActual = date("d",strtotime($fechaActual));
            $diasMora = $diaActual - $diaCreado;
            if($monto != 0 && $mesCreado < $mesActual){
                $sql1 = 'UPDATE credito SET monto='.intval($monto+($monto*(30*$interesMora/100))).' WHERE id='.$idCredito;
                $con->query($sql1);
                $mensaje = "No ha pagado su crédito por ".$monto.' se encuentra en mora.';
                $correo = new ManejoCorreo($email,"Mora Crédito",$mensaje);
                $correo->enviar_mail("visitante");
            }
            if($monto != 0 && $mesCreado == $mesActual){
                $sql1 = 'UPDATE credito SET monto='.intval($monto+($monto*($diasMora*$interesMora/100))).' WHERE id='.$idCredito;
                $con->query($sql1);
                $mensaje = "No ha pagado su crédito por ".$monto.' se encuentra en mora.';
                $correo = new ManejoCorreo($email,"Mora Crédito",$mensaje);
                $correo->enviar_mail("visitante");
            }
        }
    }
}

private function CobrarTarjetasCredito($mesActual){
  $con =$this->connection->connection();
  
  $sql1 = 'SELECT * FROM compra_credito';
  if($con->query($sql1)->rowCount() != 0){
      
      foreach ($con->query($sql1) as $fila) {
          $fechaCompra = $fila['fecha_realizado'];
          $numeroCuotas = $fila['numero_cuotas'];
          $cuotasRestantes = $fila['cuotas_restantes'];
          $idTarjeta = $fila['id_producto'];
          $monto = $fila['monto'];
          $pago = $monto/$numeroCuotas;
          date_default_timezone_set('America/Bogota');
          $fechaCompra = strtotime( $fechaCompra );
          $fechaCompra = intval(date( 'm', $fechaCompra ));
          $difMes = $mesActual - $fechaCompra;
          
          if ($difMes >= 1){
              $cuotasRestantes = $cuotasRestantes - 1;
              $sql2 = 'SELECT * FROM tarjeta_credito WHERE id='.$idTarjeta;
              if(!empty($con->query($sql2))){
                  foreach ($con->query($sql2) as $fila2) {
                      $idAhorros = $fila2['id_ahorros'];
                  }
                  $sql3 = 'SELECT * FROM cuenta_ahorros WHERE id='.$idAhorros;
                  if(!empty($con->query($sql3))){
                      foreach ($con->query($sql3) as $fila3) {
                          $saldo = $fila3['saldo'];
                          $idDueno = $fila3['id_dueno'];
                      }
                      if($saldo >= $pago){
                          $sql4 = 'UPDATE cuenta_ahorros SET saldo='.intval($saldo-$pago).' WHERE id='.$idAhorros;
                          $sql5 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES(1,'.$idDueno.',"Se ha descontado de la cuenta de ahorros para pagar una compra de '.$monto.' hecha con tarjeta de crédito.")';
                          $sql6 = 'INSERT INTO movimientos_admin (id_admin,id_producto,id_operacion,fecha_realizado) VALUES(1,'.$idTarjeta.',6,NOW())';
                          $sql7 = 'UPDATE compra_credito SET monto='.intval($monto-$pago).', cuotas_restantes='.intval($cuotasRestantes).' WHERE id_producto='.$idTarjeta;
                          if($cuotasRestantes == 0){
                              $sql8 = 'DELETE FROM compra_credito WHERE id_producto='.$idTarjeta;
                              $con->query($sql8);
                          }
                          $con->query($sql4);
                          $con->query($sql5);
                          $con->query($sql6);
                          $con->query($sql7);
                      }else{
                          $sql8 = 'SELECT * FROM usuarios WHERE id='.$idDueno;
                          if(!empty($con->query($sql8))){
                              foreach ($con->query($sql8) as $fila4) {
                                  $email = $fila4['emailadd'];
                                  $un = $fila4['user_name'];
                              }
                          }
                          $mensaje = "No hay fondos suficientes para pagar compra hecha con tarjeta de crédito";
                          $correo = new ManejoCorreo($email,"Fondos Insuficientes",$mensaje);
                          $correo->enviar_mail($un);
                      }
                  }
              }
          }
      }
  }
}

private function AumentarSaldoCA(){
  $con =$this->connection->connection();
  
  $sql1 = 'SELECT * FROM cuenta_ahorros';
  if(!empty($con->query($sql1))){
      foreach ($con->query($sql1) as $fila) {
          $idCuenta = $fila['id'];
          $monto = $fila['saldo'];
          $idDueno = $fila['id_dueno'];
          $tasa = $fila['tasa_interes'];
          $monto = $monto+($tasa*$monto/100);
          $sql2 = 'UPDATE cuenta_ahorros SET saldo='.$monto.' WHERE id='.$idCuenta;
          $sql3 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES(1,'.$idDueno.',"Se ha hecho un aumento de saldo por fin de mes.")';
          $sql4 = 'INSERT INTO movimientos_admin (id_admin,id_producto,id_operacion,fecha_realizado) VALUES(1,'.$idCuenta.',6,NOW())';
          $con->query($sql2);
          $con->query($sql3);
          $con->query($sql4);
      }
  }
}
private function CobrarCuotaManejoTarjetas(){
  $con =$this->connection->connection();

  $sql0 = 'SELECT * FROM cuenta_ahorros';
  $sql1 = 'SELECT * FROM tarjeta_credito';
  if(!empty($con->query($sql0))){
      foreach ($con->query($sql0) as $fila) {
          $idAhorros = $fila['id'];
          $idDueno = $fila['id_dueno'];
          $cuota = $fila['cuota_manejo'];
          $monto = $fila['saldo'];
          if($monto>=$cuota){
              $sql3 = 'UPDATE cuenta_ahorros SET saldo='.intval($monto-$cuota).' WHERE id='.$idAhorros;
              $sql4 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES(1,'.$idDueno.',"Se ha hecho un descuento de '.$cuota.' para pago de cuota de manejo por fin de mes.")';
              $sql5 = 'INSERT INTO movimientos_admin (id_admin,id_producto,id_operacion,fecha_realizado) VALUES(1,'.$idAhorros.',6,NOW())';                    
              $con->query($sql3);
              $con->query($sql4);
              $con->query($sql5);
          }else{
              echo "No hay fondos suficientes para pagar la cuota de manejo para cuenta de ahorros con id ".$idAhorros;
          }
      }
  }
  if(!empty($con->query($sql1))){
      foreach ($con->query($sql1) as $fila) {
          $idTarjeta = $fila['id'];
          $idDueno = $fila['id_dueno'];
          $cuota = $fila['cuota_manejo'];
          $idAhorros = $fila['id_ahorros'];
          $sql2 = 'SELECT * FROM cuenta_ahorros WHERE id='.$idAhorros;
          foreach($con->query($sql2) as $fila2){
              $monto = $fila2['saldo'];
          }
          if($monto>=$cuota){
              $sql3 = 'UPDATE cuenta_ahorros SET saldo='.intval($monto-$cuota).' WHERE id='.$idAhorros;
              $sql4 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES(1,'.$idDueno.',"Se ha hecho un descuento de '.$cuota.' para pago de cuota de manejo por fin de mes.")';
              $sql5 = 'INSERT INTO movimientos_admin (id_admin,id_producto,id_operacion,fecha_realizado) VALUES(1,'.$idTarjeta.',6,NOW())';                    
              $con->query($sql3);
              $con->query($sql4);
              $con->query($sql5);
          }else{
              echo "No hay fondos suficientes para pagar la cuota de manejo para tarjeta con id ".$idTarjeta;
          }
      }
  }

}

}
?>
