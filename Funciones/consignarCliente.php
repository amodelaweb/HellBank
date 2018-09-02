<?php
    include_once dirname(__FILE__) . '/Database.php';

    $idProductoOrigen = $_POST['idProductoOrigen'];
    $tipoProducto = $_POST['tipoProducto'];
    $idProductoDestino = $_POST['idProductoDestino'];
    $monto = $_POST['monto'];
    $tipoMoneda = $_POST['tipoMoneda'];
    $dataBase = new Database();
    $con = $dataBase->connection();
    ClienteConsignar($idProductoOrigen,$tipoProducto,$idProductoDestino,$monto,$tipoMoneda);
    function ClienteConsignar($idProductoOrigen,$tipoProducto,$idProductoDestino,$monto,$tipoMoneda){
        $sql1 = 'SELECT * FROM cuenta_ahorros WHERE id = '.$idProductoOrigen;
        if(!empty($con->query($sql1))){
            if ($tipoProducto == "ahorros"){
                $sql2 = 'SELECT * FROM cuenta_ahorros WHERE id = '.$idProductoDestino;
                if(!empty($con->query($sql2))){
                    if ($tipoMoneda == "pesos"){
                        $monto = $monto/1000;
                    }
                    foreach ($con->query($sql1) as $res1) {
                        $res1 = $res1['monto'];
                    }
                    $montoOrigen = $res1-$monto;
                    foreach ($con->query($sql2) as $res2) {
                        $res2 = $res2['monto'];
                    }
                    $montoDestino = $res2+$monto;
                    if($res1 >= $monto){
                        $sql3 = 'UPDATE cuenta_ahorros SET monto ='.$montoOrigen.' WHERE id = '.$idProductoOrigen;
                        $sql4 = 'UPDATE cuenta_ahorros SET monto ='.$montoDestino.' WHERE id = '.$idProductoDestino;
                        $sql5 = 'INSERT INTO consignacion_debito (id_origen,id_destino, monto, fecha_realizado) VALUES ('.$idProductoOrigen.','.$idProductoDestino.','.$monto.',NOW())';
                        $sql6 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$idProductoOrigen.','.$idProductoDestino.',"Se ha hecho una consignación por '.$monto.'")';
                        $con->query($sql3);
                        $con->query($sql4);
                        $con->query($sql5);
                        $con->query($sql6);
                        echo "Consignación Realizada";
                    }else{
                        echo "No hay fondos suficientes";
                    }
                }else{
                    echo "No existe cuenta de ahorros de destino";
                }
            }elseif($tipoProducto == "credito"){
                $sql2 = 'SELECT * FROM credito WHERE id = '.$idProductoDestino;
                if(!empty($con->query($sql2))){
                    if ($tipoMoneda == "pesos"){
                        $monto = $monto/1000;
                    }
                    foreach ($con->query($sql1) as $res1) {
                        $res1 = $res1['monto'];
                    }
                    $montoOrigen = $res1-$monto;
                    foreach ($con->query($sql2) as $res2) {
                        $res2 = $res2['monto'];
                    }
                    if($res2 != 0){
                        $montoDestino = $res2-$monto;
                        if($res1 >= $monto){
                            if($montoDestino != 0){
                                $montoOrigen += $montoDestino;
                            }
                            $sql3 = 'UPDATE cuenta_ahorros SET monto ='.$montoOrigen.' WHERE id = '.$idProductoOrigen;
                            $sql4 = 'UPDATE credito SET monto ='.$montoDestino.', ultimo_pago= NOW() WHERE id = '.$idProductoDestino;
                            $sql5 = 'INSERT INTO consignacion_debito (id_origen,id_destino, monto, fecha_realizado) VALUES ('.$idProductoOrigen.','.$idProductoDestino.','.$monto.',NOW())';
                            $sql6 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$idProductoOrigen.','.$idProductoDestino.',"Se ha hecho una consignación por '.$monto.'")';
                            $con->query($sql3);
                            $con->query($sql4);
                            $con->query($sql5);
                            $con->query($sql6);
                            echo "Consignación Realizada";
                        }else{
                            echo "No hay fondos suficientes";
                        }
                    }else{
                        echo "No se puede hacer la consignación porque el crédito se encuentra en 0 javecoins.";
                    }
                }else{
                    echo "No existe crédito de destino";
                }       
            }
        }else{
            echo "Producto de origen no encontrado";
        }
    }
?>