<?php
    require_once '../initializer.php';
    
    if(($_POST['Titolare'] == '') || $_POST['Mese'] == '' || $_POST['Anno'] == '' || $_POST['Numero'] == '') {
        echo json_encode(array('result' => 'warning', 'message' => 'Dati mancanti'));
    } else if(strlen($_POST['Numero']) != 16){
        echo json_encode(array('result' => 'warning', 'message' => 'Numero Errato'));
    }else if($_POST['Mese'] > 12 || 
             $_POST['Mese'] < 1 || 
             strlen($_POST['Anno']) != 4){
        echo json_encode(array('result' => 'warning', 'message' => 'Data Errata'));
    }else{
        $Titolare = $_POST['Titolare'];
        $Anno = $_POST['Anno'];
        $Mese = $_POST['Mese'];
        $Numero = $_POST['Numero'];

        $result = $dbh->insertPayment($Titolare, $Anno."-".$Mese."-"."00", $Numero, $_SESSION["idUtente"]);
        if (count($result)!=0) {
            echo json_encode(array('result' => 'ok', 'message' => 'Inserimento Effettuato con successo!', "id" => $result));
        } else {
            echo json_encode(array('result' => 'error', 'message' => 'Qualcosa non va, controlla i dati inseriti!'));
        }
    }
?>