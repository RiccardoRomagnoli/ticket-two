<?php
    require_once '../initializer.php';
    
    if(isUserLoggedIn()) {
        $notifica = $dbh->getNotReadNotify($_SESSION['idUtente']);
        if (count($notifica)==1) {
            echo json_encode(array('result' => 'ok', 'text' => $notifica[0]["Testo"], 'date' => $notifica[0]["Data"]));
            $dbh->updateNotify($notifica[0]["IdNotifica"]);
        }else{
            echo json_encode(array('result' => 'no'));
        }
    }
?>