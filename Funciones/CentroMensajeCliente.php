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
    <title>Centro de Mensajes</title>
</head>

<body>
        <h1>Centro de Mensajes</h1>
        <?php
          include_once ('..'.'/Database.php');
            $dataBase = new Database();
            $con = $dataBase->connection();
            $id_user = 1;
            $sql1 = 'SELECT * FROM mensajes WHERE id_destino='.$id_user.' OR id_origen='.$id_user;
            if($con->query($sql1)->rowCount() != 0){
                $info = array();
                $str_datos = "";
                $str_datos.= '<table style = "width:100%" border =:"1px solid black">';
                $str_datos.= '<tr>';
                $str_datos .= '<th>Id_origen</th>';
                $str_datos .= '<th>Id_destino</th>';
                $str_datos .= '<th>Mensaje</th>';
                $str_datos.= '</tr>';
                foreach ($con->query($sql1) as $fila) {
                    array_push($info,array($fila['id_origen'], $fila['id_destino'], $fila['contenido']));
                }
                foreach($info as $elm){
                    $str_datos.= '<tr>';
                    $str_datos.= '<td>'.$elm[0].'</td>';
                    $str_datos.= '<td>'.$elm[1].'</td>';
                    $str_datos.= '<td>'.$elm[2].'</td>';
                    $str_datos.= '</tr>';
                }
                $str_datos.= '</table>';
                echo $str_datos;
            }else{
                echo "No hay mensajes.";
            }
        ?>
</body>

</html>
