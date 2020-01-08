<?php
    require_once '../initializer.php';

    if(($_POST['Password'] == '') || $_POST['GuestId'] == '') {
        echo json_encode(array('result' => 'warning', 'message' => 'Parametri mancanti'));
    } else {
        $Password = $_POST['Password'];
        $GuestId = $_POST['GuestId'];
        
        $result = $dbh->getUserById($dbh->registerGuest($Password, $GuestId));
        if (count($result)==1) {
            echo json_encode(array('result' => 'ok', 'message' => 'Registrazione effettuata con successo!'));
            registerLoggedUser($result[0]);
            unset($_COOKIE['idAcquisto']); 
            setcookie('idAcquisto', null, -1, '/');
        }else {
            echo json_encode(array('result' => 'error', 'message' => 'Qualcosa non va, controlla i dati inseriti!'));
        }
    }
?>