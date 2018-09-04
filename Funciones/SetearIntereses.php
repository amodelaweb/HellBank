<?php 
    include_once dirname(__FILE__) . "\Database.php";

    $iCA = $_POST['iCA'];
    $iCV = $_POST['iCV'];
    $COB = $_POST['COB'];    

    SetearIntereses($iCA,$iCV,$COB);
    function SetearIntereses($iCA,$iCV,$COB){
        $dataBase = new Database();
        $con = $dataBase->connection();

        //Cuentas de Ahorro
        $sql0 = 'SELECT * FROM cuenta_ahorros';
        if($iCA != 0){
            if($con->query($sql0)->rowCount() != 0){
                $sql1 = 'UPDATE cuenta_ahorros SET tasa_interes ='.$iCA;
                $con->query($sql1);
            }
        }
        //Creditos
        $sql0 = 'SELECT * FROM credito WHERE email_vis != "N/A"';
        if($iCV != 0){
            if($con->query($sql0)->rowCount() != 0){
                $sql1 = 'UPDATE credito SET tasa_interes ='.$iCV;
                $con->query($sql1);
            }
        }
        //Transferencias
        $sql0 = 'SELECT * FROM transferencias_externas';
        if($iCV != 0){
            if($con->query($sql0)->rowCount() != 0){
                $sql1 = 'UPDATE transferencias_externas SET interes ='.$COB;
                $con->query($sql1);
            }
        }
        echo "Intereses colocados<br>";
    }
    
?>