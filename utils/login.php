<?php
    require_once '../initializer.php';
    
    if(($_POST['mail'] == '') || $_POST['password'] == '') {
        echo json_encode(array('result' => 'warning', 'message' => 'Parametri mancanti'));
    } else {
        $mail = $_POST['mail'];
        $password = $_POST['password'];

        $result = $dbh->getUser($mail, $password);
        if (count($result)==1) {
            echo json_encode(array('result' => 'ok', 'message' => 'Login Effettuato con successo!'));
            registerLoggedUser($result[0]);
        } else {
            echo json_encode(array('result' => 'error', 'message' => 'Qualcosa non va, controlla i dati inseriti!'));
        }
    }
?>