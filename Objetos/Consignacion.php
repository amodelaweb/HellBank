<?php
    class Consignacion
    {
        private $id;
        private $idDestino;
        private $monto;
        private $fecha;
        private $moneda;
        private $connection ;

        public function __construct($conn)
        {
            $this->connection = $conn ;
        }

        public function ClienteConsignar($idProductoOrigen, $tipoProducto, $idProductoDestino, $monto, $tipoMoneda)
        {
            $con = $this->connection ;
            $sql1 = 'SELECT * FROM cuenta_ahorros WHERE id = '.$idProductoOrigen;
            if (!empty($con->query($sql1))) {
                if ($tipoProducto == "ahorros") {
                    $sql2 = 'SELECT * FROM cuenta_ahorros WHERE id = '.$idProductoDestino;
                    if ($con->query($sql2)->rowCount() != 0) {
                        if ($tipoMoneda == "pesos") {
                            $monto = $monto/1000;
                        }
                        foreach ($con->query($sql1) as $res1) {
                            $idDuenoOr = $res1['id_dueno'];
                            $res1 = $res1['saldo'];
                        }
                        $montoOrigen = $res1-$monto;
                        foreach ($con->query($sql2) as $res2) {
                            $idDuenoDes = $res2['id_dueno'];
                            $res2 = $res2['saldo'];
                        }
                        $montoDestino = $res2+$monto;
                        if ($res1 >= $monto) {
                            $sql3 = 'UPDATE cuenta_ahorros SET saldo ='.$montoOrigen.' WHERE id = '.$idProductoOrigen;
                            $sql4 = 'UPDATE cuenta_ahorros SET saldo ='.$montoDestino.' WHERE id = '.$idProductoDestino;
                            $sql5 = 'INSERT INTO consignacion_debito (id_origen,id_destino, monto, fecha_realizado) VALUES ('.$idProductoOrigen.','.$idProductoDestino.','.$monto.',NOW())';
                            $sql6 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$idDuenoOr.','.$idDuenoDes.',"Se ha hecho una consignación por '.$monto.'")';
                            $con->query($sql3);
                            $con->query($sql4);
                            $con->query($sql5);
                            $con->query($sql6);
                            return array( 'band' => true , "msn" =>  "Consignación Realizada");
                        } else {
                            return array( 'band' => false , "msn" =>  "No hay fondos suficientes");
                        }
                    } else {
                        return array( 'band' => false , "msn" =>  "No existe cuenta de ahorros de destino");
                    }
                } elseif ($tipoProducto == "credito") {
                    $sql2 = 'SELECT * FROM credito WHERE id = '.$idProductoDestino;
                    if ($con->query($sql2)->rowCount() != 0) {
                        if ($tipoMoneda == "pesos") {
                            $monto = $monto/1000;
                        }
                        foreach ($con->query($sql1) as $res1) {
                            $idDuenoOr = $res1['id_dueno'];
                            $res1 = $res1['saldo'];
                        }
                        $montoOrigen = $res1-$monto;
                        foreach ($con->query($sql2) as $res2) {
                            $idDuenoDes = $res2['id_dueno'];
                            $res2 = $res2['monto'];
                        }
                        if ($res2 != 0) {
                            $montoDestino = $res2-$monto;
                            if ($res1 >= $monto) {
                                if ($montoDestino != 0) {
                                    $montoOrigen += $montoDestino;
                                }
                                $sql3 = 'UPDATE cuenta_ahorros SET saldo ='.$montoOrigen.' WHERE id = '.$idProductoOrigen;
                                $sql4 = 'UPDATE credito SET monto ='.$montoDestino.', ultimo_pago= NOW() WHERE id = '.$idProductoDestino;
                                $sql5 = 'INSERT INTO consignacion_credito (id_origen,id_destino, monto, fecha_realizado) VALUES ('.$idProductoOrigen.','.$idProductoDestino.','.$monto.',NOW())';
                                $sql6 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$idDuenoOr.','.$idDuenoDes.',"Se ha hecho una consignación por '.$monto.'")';
                                $con->query($sql3);
                                $con->query($sql4);
                                $con->query($sql5);
                                $con->query($sql6);
                                return array( 'band' => true , "msn" =>  "Consignación Realizada");
                            } else {
                                return array( 'band' => false , "msn" =>  "No hay fondos suficientes");
                            }
                        } else {
                            return array( 'band' => false , "msn" =>  "No se puede hacer la consignación porque el crédito se encuentra en 0 javecoins.");
                        }
                    } else {
                        return array( 'band' => false , "msn" =>  "No existe crédito de destino");
                    }
                }
            } else {
                return array( 'band' => false , "msn" =>  "Producto de origen no encontrado");
            }
            return array ( "band" => false , "msn" =>  "Unexpected error" );
        }

        public function VisitanteConsignar($tipoProducto, $idProductoDestino, $monto, $tipoMoneda, $cedula)
        {

            $con = $this->connection ;
            if ($tipoProducto == "ahorros") {
                $sql2 = 'SELECT * FROM cuenta_ahorros WHERE id = '.$idProductoDestino;
                if ($con->query($sql2)->rowCount() != 0) {
                    if ($tipoMoneda == "pesos") {
                        $monto = $monto/1000;
                    }
                    foreach ($con->query($sql2) as $res2) {
                        $idDuenoOr = $res2['id_dueno'];
                        $res2 = $res2['monto'];
                    }
                    $montoDestino = $res2+$monto;
                    $sql4 = 'UPDATE cuenta_ahorros SET monto ='.$montoDestino.' WHERE id = '.$idProductoDestino;
                    $sql5 = 'INSERT INTO consignacion_debito (id_origen,id_destino, monto, fecha_realizado) VALUES ('.$cedula.','.$idProductoDestino.','.$monto.',NOW())';
                    $sql6 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$cedula.','.$idDuenoOr.',"Se ha hecho una consignación por '.$monto.'")';
                    $con->query($sql4);
                    $con->query($sql5);
                    $con->query($sql6);
                    return array ( "band" => false , "msn" =>  "Consignación Realizada" );
                } else {
                    return array ( "band" => false , "msn" =>  "No existe cuenta de ahorros de destino" );
                }
            } elseif ($tipoProducto == "credito") {
                $sql2 = 'SELECT * FROM credito WHERE id = '.$idProductoDestino;
                if ($con->query($sql2)->rowCount() != 0) {
                    if ($tipoMoneda == "pesos") {
                        $monto = $monto/1000;
                    }
                    foreach ($con->query($sql2) as $res2) {
                        $idDuenoOr = $res2['id_dueno'];
                        $res2 = $res2['monto'];
                    }
                    if ($res2 != 0) {
                        $montoDestino = $res2-$monto;
                        if ($montoDestino != 0) {
                            $monto += $montoDestino;
                        }
                    }
                    $sql4 = 'UPDATE credito SET monto ='.$montoDestino.', ultimo_pago= NOW() WHERE id = '.$idProductoDestino;
                    $sql5 = 'INSERT INTO consignacion_credito (id_origen,id_destino, monto, fecha_realizado) VALUES ('.$cedula.','.$idProductoDestino.','.$monto.',NOW())';
                    $sql6 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$cedula.','.$idDuenoOr.',"Se ha hecho una consignación por '.$monto.'")';
                    $con->query($sql4);
                    $con->query($sql5);
                    $con->query($sql6);
                    return array ( "band" => false , "msn" =>  "Consignación Realizada" );
                    return array ( "band" => false , "msn" =>  "<br> Sobran ".intval($monto-$montoDestino) );
                } else {
                    return array ( "band" => false , "msn" =>  "No se puede hacer la consignación porque el crédito se encuentra en 0 javecoins." );
                }
            } else {
                return array ( "band" => false , "msn" =>  "No existe crédito de destino" );
            }

            return array ( "band" => false , "msn" =>  "Unexpected error" );
        }
    }
