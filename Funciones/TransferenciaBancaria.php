<?php
    include_once dirname(__FILE__) . "\Database.php";

    EnviarTransferencia("HellBank","Bank",1,20000,1,"Consignación");
    RecibirTransferencia("Bank","HellBank",1,20000,1,"Consignación");
    function EnviarTransferencia($bancoOr,$bancoDest,$idOrigen,$monto,$idDest,$tipoTrans){
        $dataBase = new Database();
        $con = $dataBase->connection();

        $sql0 = 'INSERT INTO transferencias_externas(banco_origen,banco_destino,id_origen,monto,id_destino,fecha_realizado,tipo_trans) 
        VALUES("'.$bancoOr.'","'.$bancoDest.'",'.$idOrigen.','.$monto.','.$idDest.',NOW(),"'.$tipoTrans.'")';
        $con->query($sql0);
    }
    function RecibirTransferencia($bancoOr,$bancoDest,$idOrigen,$monto,$idDest,$tipoTrans){
        $dataBase = new Database();
        $con = $dataBase->connection();


        $sql0 = 'INSERT INTO transferencias_externas(banco_origen,banco_destino,id_origen,monto,id_destino,fecha_realizado,tipo_trans) 
        VALUES("'.$bancoOr.'","'.$bancoDest.'",'.$idOrigen.','.$monto.','.$idDest.',NOW(),"'.$tipoTrans.'")';
        $con->query($sql0);
    }

?>