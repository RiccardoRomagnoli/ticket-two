<?php
    require_once '../initializer.php';
    
    if(($_POST['IdRigaCarrello'] == '')) {
        echo json_encode(array('result' => 'error', 'message' => 'Errore Segnalato ai Tecnici'));
    } else {
        $IdRigaCarrello = $_POST['IdRigaCarrello'];

        $result = $dbh->removeCart($IdRigaCarrello);
        if (count($result)==0) {
            echo json_encode(array('result' => 'error', 'message' => 'Rimozione non avvenuta'));
        } else {
            echo json_encode(array('result' => 'ok', 'message' => 'Rimozione Avvenuta con successo!'));
        }
    }
?>