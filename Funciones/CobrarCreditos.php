<?php
    include_once dirname(__FILE__) . "\Database.php";
    include_once dirname(__FILE__) . "\ManejoCorreo.php";


    function CobrarCreditos($idAdmin, $fechaActual){
        $dataBase = new Database();
        $con = $dataBase->connection();
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
?>