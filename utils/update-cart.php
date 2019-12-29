<?php
    require_once '../initializer.php';
    
    if(($_POST['Nome'] == '') || ($_POST['Cognome'] == '') || ($_POST['DataNascita'] == '')) {
        echo json_encode(array('result' => 'warning', 'message' => 'Compila correttamente tutti i campi'));
    } else {
        $IdRiga = $_POST['IdRigaCarrello'];
        $Nome = $_POST['Nome'];
        $Cognome = $_POST['Cognome'];
        $DataNascita = $_POST['DataNascita'];

        $result = $dbh->updateCart($IdRiga, $Nome, $Cognome, $DataNascita);
        if (count($result)==0) {
            echo json_encode(array('result' => 'error', 'message' => 'Salvataggio non riuscito'));
        } else {
            echo json_encode(array('result' => 'ok', 'message' => 'Salvataggio Riuscito!'));
        }
    }
?>