<?php
    include_once dirname(__FILE__) . '/Sistema.php';
    include_once dirname(__FILE__) . '/Usuario.php';
    include_once dirname(__FILE__) . '/Visitante.php';
    include_once dirname(__FILE__) . '/CentroMensajes.php';
    include_once dirname(__FILE__) . '/CuentaAhorros.php';
    include_once dirname(__FILE__) . '/TarjetaCredito.php';
    include_once dirname(__FILE__) . '/Credito.php';
    include_once dirname(__FILE__) . '/Retiro.php';
    include_once dirname(__FILE__) . '/Consignacion.php';
    include_once dirname(__FILE__) . '/ComprarTarjetaCredito.php';


    $sistema = new Sistema(12000);
    $cliente = new Usuario(1,"xsd","Cliente");
    $sistema->addUsuario($cliente);
    echo $cliente->getRol();
    $visitante = new Visitante("xsdssss",2345);
    echo $visitante->getEmail();
    $cMensajes = new CentroMensajes(2,"Holi soy yo");
    $cAhorros = new CuentaAhorros(1,2,3,4);
    echo $cAhorros->getId();
    $tCredito = new TarjetaCredito(18,2,3,4,5,6);
    echo $tCredito->getId();
    $credito = new Credito(2,3,4,5,6,7,8);
    echo $credito->getId();
    $retiro = new Retiro(5,6,7,8);
    $consignación = new Consignacion(4,5,6,7,8);
    $comprarTC = new ComprarTarjetaCredito(9,8,7,6,5);
?>