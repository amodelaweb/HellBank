<?php
    include_once dirname(__FILE__) . "\Database.php";

    $idProdOrigen = $_POST['idOrigen'];
    $cantRetirar = $_POST['cantRetirar'];
    retirar($idProdOrigen,$cantRetirar);

?>
