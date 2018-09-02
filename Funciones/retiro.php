<?php
    include_once dirname(__FILE__) . "\Database.php";

    $idProdOrigen = $_POST['idOrigen'];
    $cantRetirar = $_POST['cantRetirar'];
    retirar($idProdOrigen,$cantRetirar);
    function retirar($idProdOrigen,$cantRetirar){
        $dataBase = new Database();
        $con = $dataBase->connection();
        $sql1 = 'SELECT * FROM cuenta_ahorros WHERE id = '.$idProdOrigen;
        if(!empty($con->query($sql1))){
            foreach ($con->query($sql1) as $res1) {
                $res = $res1['monto'];
                $idCA = $res1['id'];
            }
            $montoOrigen = $res-$cantRetirar;
            if($res >= $cantRetirar){
                $sql3 = 'UPDATE cuenta_ahorros SET monto ='.$montoOrigen.' WHERE id = '.$idProdOrigen;
                $sql4 = 'INSERT INTO retiro (id_ahorros,monto,fecha_realizado) VALUES('.$idCA.','.$cantRetirar.',NOW())';
                $sql5 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$idCA.',1,"Se ha hecho un retiro por '.$cantRetirar.'")';
                $con->query($sql3);
                $con->query($sql4);
                $con->query($sql5);
                echo "Retiro Realizado";
            }else{
                echo "No hay fondos suficientes";
            }
        }else{
            echo "Producto de origen no existe";
        }
    }
?>