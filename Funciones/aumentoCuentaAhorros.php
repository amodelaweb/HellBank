<?php
    include_once dirname(__FILE__) . "\Database.php";

    aumentarSaldoCA();

    function aumentarSaldoCA(){
        $dataBase = new Database();
        $con = $dataBase->connection();
        
        $sql1 = 'SELECT * FROM cuenta_ahorros';
        if(!empty($con->query($sql1))){
            foreach ($con->query($sql1) as $fila) {
                $idCuenta = $fila['id'];
                $monto = $fila['saldo'];
                $idDueno = $fila['id_dueno'];
                $tasa = $fila['tasa_interes'];
                $monto = $monto+($tasa*$monto/100);
                $sql2 = 'UPDATE cuenta_ahorros SET saldo='.$monto.' WHERE id='.$idCuenta;
                $sql3 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES(1,'.$idCuenta.',"Se ha hecho un aumento de saldo por fin de mes.")';
                $sql4 = 'INSERT INTO movimientos_admin (id_admin,id_producto,id_operacion,fecha_realizado) VALUES(1,'.$idCuenta.',6,NOW())';
                $con->query($sql2);
                $con->query($sql3);
                $con->query($sql4);
            }
        }
    }
?>