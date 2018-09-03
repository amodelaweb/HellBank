<?php
    include_once dirname(__FILE__) . "\Database.php";
    $idTarjeta= $_POST['idOrigen'];
    $numCuotas= $_POST['idOrigen'];
    $mont= $_POST['idOrigen'];
    $tipoMoneda= $_POST['idOrigen'];
    comprar($idTarjeta,$numCuotas,$mont,$tipoMoneda);
        function comprar($idTarjeta,$numCuotas,$mont,$tipoMoneda){
          $dataBase = new Database();
          $con = $dataBase->connection();
          $sql1 = 'SELECT * FROM tarjeta_credito WHERE id = '.$idTarjeta;
          if(!empty($con->query($sql1))){
            foreach ($con->query($sql1) as $res1) {
              $cupo_maximo = $res1['cupo_maximo'];
              $gastado = $res1['gastado'];
              $sobre_cupo = $res1['sobre_cupo'];
              $id_dueno = $res1['id_dueno'];
            }
            $saldo = ($cupoMaximo+$sobre_cupo)-$gastado;
            if($saldo >= $mont){
              if ($tipoMoneda=="Pesos") {
                $mont=$mont/1000;
              }
              $gastado= $gastado+$mont;
              $sql2 = 'UPDATE tarjeta_credito SET gastado ='.$gastado.' WHERE id = '.$idTarjeta;
              $sql3 = 'INSERT INTO compra_credito (id_producto,monto,numero_cuotas,fecha_realizado) VALUES('.$idTarjeta.','.$mont.','.$numCuotas.',NOW())';
              $sql4 = 'INSERT INTO mensajes (id_origen,id_destino,contenido) VALUES('.$id_dueno.','.$id_dueno.',"Se ha hecho una compra por '.$mont.'")';
              $con->query($sql2);
              $con->query($sql3);
              $con->query($sql4);
              echo "compra Realizada";
            }else{
                echo "No hay fondos suficientes";
            }
        }else{
            echo "Producto de origen no existe";

          }
        }

?>
