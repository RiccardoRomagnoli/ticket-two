<?php
    require_once '../initializer.php';
    
    if(!isset($_POST['username']) || !isset($_POST['password'])) {
        echo json_encode(array('result' => 'Parametri errati'));
    } else {
        $user = $_POST['username'];
        $password = $_POST['password'];

        $result = $dbh->getUser($user, $password);
        if (count($result)==1) {
            echo json_encode(array('result' => 'ok', 'message' => 'Login Effettuato con successo!'));
            registerLoggedUser($result[0]);
        } else {
            echo json_encode(array('result' => 'error', 'message' => 'Qualcosa non va, controlla i dati inseriti!'));
        }
    }
?>