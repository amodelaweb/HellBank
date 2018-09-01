<?php
    include_once dirname(__FILE__) . '/Database.php';

    $tipoProducto = $_POST['tipoProducto'];
    $idProductoDestino = $_POST['idProductoDestino'];
    $cedula = $_POST['cedula'];
    $monto = $_POST['monto'];
    $tipoMoneda = $_POST['tipoMoneda'];
    $dataBase = new Database();
    $con = $dataBase->connection();
    VisitanteConsignar($tipoProducto,$idProductoDestino,$monto,$tipoMoneda,$cedula);
    function VisitanteConsignar($tipoProducto,$idProductoDestino,$monto,$tipoMoneda,$cedula){
        $dataBase = new Database();
    $con = $dataBase->connection();
        $sql0 = 'SELECT * FROM visitante WHERE id = '.$cedula;
        if(empty($con->query($sql0))){
            $sql0 = 'INSERT INTO visitante(cedula) VALUES ('.$cedula.')';
            $con->query($sql0);
        }
            if ($tipoProducto == "ahorros"){
                $sql2 = 'SELECT * FROM cuenta_ahorros WHERE id = '.$idProductoDestino;
                if(!empty($con->query($sql2))){
                    if ($tipoMoneda == "pesos"){
                        $monto = $monto/1000;
                    }
                    foreach ($con->query($sql2) as $res2) {
                        $res2 = $res2['monto'];
                    }
                    $montoDestino = $res2+$monto;
                        $sql4 = 'UPDATE cuenta_ahorros SET monto ='.$montoDestino.' WHERE id = '.$idProductoDestino;
                        $sql5 = 'INSERT INTO consignacion_debito (id_origen,id_destino, monto, fecha_realizado) VALUES ('.$cedula.','.$idProductoDestino.','.$monto.',NOW())';
                        $con->query($sql4);
                        $con->query($sql5);
                        echo "Consignación Realizada";
                }else{
                    echo "No existe cuenta de ahorros de destino";
                }
            }elseif($tipoProducto == "credito"){
                $sql2 = 'SELECT * FROM credito WHERE id = '.$idProductoDestino;
                if(!empty($con->query($sql2))){
                    if ($tipoMoneda == "pesos"){
                        $monto = $monto/1000;
                    }
                    foreach ($con->query($sql2) as $res2) {
                        $res2 = $res2['monto'];
                    }
                    if($res2 != 0){
                        $montoDestino = $res2-$monto;
                            if($montoDestino == 0){
                                $sql4 = 'UPDATE credito SET monto ='.$montoDestino.', ultimo_pago= NOW() WHERE id = '.$idProductoDestino;
                                $sql5 = 'INSERT INTO consignacion_debito (id_origen,id_destino, monto, fecha_realizado) VALUES ('.$cedula.','.$idProductoDestino.','.$monto.',NOW())';
                                $con->query($sql4);
                                $con->query($sql5);
                            }else{
                                $monto += $montoDestino;
                                $sql4 = 'UPDATE credito SET monto ='.$montoDestino.', ultimo_pago= NOW() WHERE id = '.$idProductoDestino;
                                $sql5 = 'INSERT INTO consignacion_credito (id_origen,id_destino, monto, fecha_realizado) VALUES ('.$cedula.','.$idProductoDestino.','.$monto.',NOW())';
                                $con->query($sql4);
                                $con->query($sql5);                        
                            }
                            echo "Consignación Realizada";
                            echo "<br> Sobran ".intval($monto-$montoDestino);
                    }else{
                        echo "No se puede hacer la consignación porque el crédito se encuentra en 0 javecoins.";
                    }
                }else{
                    echo "No existe crédito de destino";
                }       
            }
    }
?>