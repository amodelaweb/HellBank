<?php
    include_once dirname(__FILE__) . "\Database.php";
    include_once dirname(__FILE__) . "\ManejoCorreo.php";


    function CobrarTarjetasCredito($mesActual){
        $dataBase = new Database();
        $con = $dataBase->connection();
        
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
?>