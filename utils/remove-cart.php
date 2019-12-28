<?php
    require_once '../initializer.php';
    
    if(($_POST['IdCategoria'] == '')) {
        echo json_encode(array('result' => 'error', 'message' => 'Errore Segnalato ai Tecnici'));
    } else {
        $IdCategoria = $_POST['IdCategoria'];
        $IdUtente = $_SESSION["idUtente"];

        $result = $dbh->addInterest($IdCategoria, $IdUtente);
        if (count($result)==0) {
            echo json_encode(array('result' => 'error', 'message' => 'Aggiunta non avvenuta'));
        } else {
            echo json_encode(array('result' => 'ok', 'message' => 'Aggiunta Avvenuta con successo!'));
        }
    }
?>