<?php
    require_once '../initializer.php';
    
    if(($_POST['IdPagamento'] == '')) {
        echo json_encode(array('result' => 'error', 'message' => 'Errore Segnalato ai Tecnici'));
    } else {
        $IdPagamento = $_POST['IdPagamento'];

        $result = $dbh->removePayment($IdPagamento);
        if (count($result)==0) {
            echo json_encode(array('result' => 'error', 'message' => 'Remozione non avvenuta'));
        } else {
            echo json_encode(array('result' => 'ok', 'message' => 'Rimozione Avvenuta con successo!'));
        }
    }
?>