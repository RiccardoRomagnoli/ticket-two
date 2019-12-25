<?php
    require_once '../initializer.php';
    
    if(($_POST['IdInteresse'] == '')) {
        echo json_encode(array('result' => 'error', 'message' => 'Errore Segnalato ai Tecnici'));
    } else {
        $IdInteresse = $_POST['IdInteresse'];
        $IdUtente = $_SESSION["idUtente"];

        $result = $dbh->removeInterest($IdInteresse, $IdUtente);
        if (count($result)==0) {
            echo json_encode(array('result' => 'error', 'message' => 'Remozione non avvenuta'));
        } else {
            echo json_encode(array('result' => 'ok', 'message' => 'Rimozione Avvenuta con successo!'));
        }
    }
?>