<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
        crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="css/princUsVis.css">
    <title>Reporte de Movimientos</title>
</head>

<body>
        <h1>Reporte de Movimientos</h1>
        <?php
            include_once dirname(__FILE__) . '/Database.php';
            $dataBase = new Database();
            $con = $dataBase->connection();
            $id_user = 2;
            //Obtener productos usuario
            //Cuentas de Ahorros
            $sql1 = 'SELECT * FROM cuenta_ahorros WHERE id_dueno='.$id_user;
            if($con->query($sql1)->rowCount() != 0){
                $cAhorros = array();
                foreach ($con->query($sql1) as $fila) {
                    array_push($cAhorros,$fila['id']);                       
                }
            }
            //Créditos
            $sql1 = 'SELECT * FROM credito WHERE id_dueno='.$id_user;
            if($con->query($sql1)->rowCount() != 0){
                $creditos = array();
                foreach ($con->query($sql1) as $fila) {
                    array_push($creditos,$fila['id']);                       
                }
            }
            //Tarjetas crédito
            $sql1 = 'SELECT * FROM tarjeta_credito WHERE id_dueno='.$id_user;
            if($con->query($sql1)->rowCount() != 0){
                $tCredito = array();
                foreach ($con->query($sql1) as $fila) {
                    array_push($tCredito,$fila['id']);                       
                }
            }
            if(!empty($tCredito)){
                //Movimientos Tarjetas de credito
                $movTarCredito = array();
                for ($i=0; $i < count($tCredito); $i++) {
                    //Verificar tabla compra_credito
                    $sql2 = 'SELECT * FROM compra_credito WHERE id_producto='.$tCredito[$i];     
                    if($con->query($sql2)->rowCount() != 0){
                        foreach ($con->query($sql2) as $fila) {
                            array_push($movTarCredito,array($fila['id_producto'],$fila['monto'],$fila['fecha_realizado'],$fila['numero_cuotas']));    
                        }
                    }        
                }
                //Tablas
                echo "<h3>Tarjetas de Crédito</h3>";
                $str_datos = "";
                $str_datos.= '<table style = "width:100%" border =:"1px solid black">';
                $str_datos.= '<tr>';
                $str_datos .= '<th>Id_Producto</th>';
                $str_datos .= '<th>Monto</th>';
                $str_datos .= '<th>Fecha Realizado</th>';
                $str_datos .= '<th>Número de cuotas</th>';
                $str_datos.= '</tr>';
                foreach($movTarCredito as $elm){
                    $str_datos.= '<tr>';
                    $str_datos.= '<td>'.$elm[0].'</td>';
                    $str_datos.= '<td>'.$elm[1].'</td>';
                    $str_datos.= '<td>'.$elm[2].'</td>';
                    $str_datos.= '<td>'.$elm[3].'</td>';
                    $str_datos.= '</tr>';
                }            
                $str_datos.= '</table>';
                echo $str_datos;
            }else{
                echo "No posee tarjetas de crédito actualmente.<br>";
            }            
            if(!empty($creditos)){
                //Movimientos créditos
                $movCreditos = array();
                for ($i=0; $i < count($creditos); $i++) { 
                    //Verificar tabla consignacion_credito
                    $sql2 = 'SELECT * FROM consignacion_credito WHERE id_destino='.$creditos[$i];     
                    if($con->query($sql2)->rowCount() != 0){
                        foreach ($con->query($sql2) as $fila) {
                            array_push($movCreditos,array($fila['id_destino'],$fila['id_origen'],$fila['monto'],$fila['fecha_realizado']));    
                        }
                    }        
                }
                //Tablas
                echo "<h3>Créditos</h3>";
                $str_datos = "";
                $str_datos.= '<table style = "width:100%" border =:"1px solid black">';
                $str_datos.= '<tr>';
                $str_datos .= '<th>Id_destino</th>';
                $str_datos .= '<th>Id_origen</th>';
                $str_datos .= '<th>Monto</th>';
                $str_datos .= '<th>Fecha Realizado</th>';
                $str_datos.= '</tr>';
                foreach($movCreditos as $elm){
                    $str_datos.= '<tr>';
                    $str_datos.= '<td>'.$elm[0].'</td>';
                    $str_datos.= '<td>'.$elm[1].'</td>';
                    $str_datos.= '<td>'.$elm[2].'</td>';
                    $str_datos.= '<td>'.$elm[3].'</td>';
                    $str_datos.= '</tr>';
                }            
                $str_datos.= '</table>';
                echo $str_datos;
            }else{
                echo "No posee créditos actualmente.<br>";
            }
            if(!empty($cAhorros)){
                //Movimientos cuentas de ahorro
                $movCAhorrosCon = array();
                $movCAhorrosRet = array();
                $movCAhorrosTrans = array();
                for ($i=0; $i < count($cAhorros); $i++) { 
                    //Verificar tabla consignacion_debito
                    $sql2 = 'SELECT * FROM consignacion_debito WHERE id_destino='.$cAhorros[$i].' OR id_origen='.$cAhorros[$i];     
                    if($con->query($sql2)->rowCount() != 0){
                        foreach ($con->query($sql2) as $fila) {
                            array_push($movCAhorrosCon,array($fila['id_destino'],$fila['id_origen'],$fila['monto'],$fila['fecha_realizado']));    
                        }
                    }
                    //Verificar tabla retiro
                    $sql2 = 'SELECT * FROM retiro WHERE id_ahorros='.$cAhorros[$i];     
                    if($con->query($sql2)->rowCount() != 0){
                        foreach ($con->query($sql2) as $fila) {
                            array_push($movCAhorrosRet,array($fila['id_ahorros'],$fila['monto'],$fila['fecha_realizado']));    
                        }
                    }
                    //Verificar tabla transferencias_externas
                    $sql2 = 'SELECT * FROM transferencias_externas WHERE id_origen='.$cAhorros[$i];     
                    if($con->query($sql2)->rowCount() != 0){
                        foreach ($con->query($sql2) as $fila) {
                            array_push($movCAhorrosTrans,array($fila['banco_origen'],$fila['banco_destino'],$fila['id_origen'],$fila['monto'],$fila['id_destino'],$fila['fecha_realizado'],$fila['tipo_trans']));    
                        }
                    }            
                }
                //Tablas 
                echo "<h3>Cuentas de Ahorros</h3>";
                echo "<h4>Consignaciones</h4>";
                $str_datos = "";
                $str_datos.= '<table style = "width:100%" border =:"1px solid black">';
                $str_datos.= '<tr>';
                $str_datos .= '<th>Id_destino</th>';
                $str_datos .= '<th>Id_origen</th>';
                $str_datos .= '<th>Monto</th>';
                $str_datos .= '<th>Fecha Realizado</th>';
                $str_datos.= '</tr>';
                foreach($movCAhorrosCon as $elm){
                    $str_datos.= '<tr>';
                    $str_datos.= '<td>'.$elm[0].'</td>';
                    $str_datos.= '<td>'.$elm[1].'</td>';
                    $str_datos.= '<td>'.$elm[2].'</td>';
                    $str_datos.= '<td>'.$elm[3].'</td>';
                    $str_datos.= '</tr>';
                }            
                $str_datos.= '</table>';
                echo $str_datos;
                echo "<h4>Retiros</h4>";
                $str_datos = "";
                $str_datos.= '<table style = "width:100%" border =:"1px solid black">';
                $str_datos.= '<tr>';
                $str_datos .= '<th>Id_Ahorros</th>';
                $str_datos .= '<th>Monto</th>';
                $str_datos .= '<th>Fecha Realizado</th>';
                $str_datos.= '</tr>';
                foreach($movCAhorrosRet as $elm){
                    $str_datos.= '<tr>';
                    $str_datos.= '<td>'.$elm[0].'</td>';
                    $str_datos.= '<td>'.$elm[1].'</td>';
                    $str_datos.= '<td>'.$elm[2].'</td>';
                    $str_datos.= '</tr>';
                }            
                $str_datos.= '</table>';
                echo $str_datos;
                echo "<h4>Transferencias Externas</h4>";
                $str_datos = "";
                $str_datos.= '<table style = "width:100%" border =:"1px solid black">';
                $str_datos.= '<tr>';
                $str_datos .= '<th>Banco de Origen</th>';
                $str_datos .= '<th>Banco de Destino</th>';
                $str_datos .= '<th>Id_Origen</th>';
                $str_datos .= '<th>Monto</th>';
                $str_datos .= '<th>Id_Destino</th>';
                $str_datos .= '<th>Fecha Realizado</th>';
                $str_datos.= '</tr>';
                foreach($movCAhorrosTrans as $elm){
                    $str_datos.= '<tr>';
                    $str_datos.= '<td>'.$elm[0].'</td>';
                    $str_datos.= '<td>'.$elm[1].'</td>';
                    $str_datos.= '<td>'.$elm[2].'</td>';
                    $str_datos.= '<td>'.$elm[3].'</td>';
                    $str_datos.= '<td>'.$elm[4].'</td>';
                    $str_datos.= '<td>'.$elm[5].'</td>';
                    $str_datos.= '</tr>';
                }            
                $str_datos.= '</table>';
                echo $str_datos;
            }else{
                echo "No posee cuentas de ahorro actualmente.<br>";
            }
        ?>
</body>

</html>