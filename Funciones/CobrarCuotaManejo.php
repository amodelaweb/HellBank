<?php
    include_once dirname(__FILE__) . "\Database.php";

    function CobrarCuotaManejoTarjetas(){
        $dataBase = new Database();
        $con = $dataBase->connection();

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
?>