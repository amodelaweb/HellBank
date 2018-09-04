<?php 
    include_once dirname(__FILE__) . "\CobrarTarjetasCredito.php";
    include_once dirname(__FILE__) . "\AumentoCuentaAhorros.php";
    include_once dirname(__FILE__) . "\CobrarCuotaManejo.php";
    include_once dirname(__FILE__) . "\CobrarCreditos.php";

    
    $fecha = $_POST['fecha'];
    FinMes($fecha,1);

    function FinMes($fecha,$idAdmin){
        $mes = strftime("%m",strtotime($fecha));
        $fecha = strftime("%d-%m-%Y",strtotime($fecha));
        CobrarCreditos($idAdmin,$fecha);
        CobrarTarjetasCredito($mes);
        AumentarSaldoCA();
        CobrarCuotaManejoTarjetas();
        echo "<br>Fin de mes realizado con éxito";
    }
?>
