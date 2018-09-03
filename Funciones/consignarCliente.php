<?php
    include_once dirname(__FILE__) . '/Database.php';

    $idProductoOrigen = $_POST['idProductoOrigen'];
    $tipoProducto = $_POST['tipoProducto'];
    $idProductoDestino = $_POST['idProductoDestino'];
    $monto = $_POST['monto'];
    $tipoMoneda = $_POST['tipoMoneda'];
    ClienteConsignar($idProductoOrigen,$tipoProducto,$idProductoDestino,$monto,$tipoMoneda);

?>
