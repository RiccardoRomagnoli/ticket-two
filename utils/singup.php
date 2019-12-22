<?php
    require_once '../initializer.php';
    
    if(($_POST['mail'] == '') || ($_POST['password']=='') || ($_POST['passwordRip']=='') || ($_POST['name']=='') || ($_POST['surname']=='')) {
        echo json_encode(array('result' => 'warning', 'message' => 'Parametri mancanti'));
    } else if(!($_POST['passwordRip'] == $_POST['password'])){
        echo json_encode(array('result' => 'warning', 'message' => 'Le password non coincidono'));
    } else if(!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
        echo json_encode(array('result' => 'warning', 'message' => 'Indirizzo Mail non Valido'));
    } else {
        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $mail = $_POST['mail'];
        $password = $_POST['password'];
        $passwordRip = $_POST['passwordRip'];

        $result = $dbh->getUserById($dbh->insertUser($name, $surname, $mail, $password));
        if (count($result)==1) {
            echo json_encode(array('result' => 'ok', 'message' => 'Registrazione Effettuata con successo!'));
            registerLoggedUser($result[0]);
        } else {
            echo json_encode(array('result' => 'error', 'message' => 'Qualcosa non va, Non siamo riusciti a registrarti!'));
        }
    }
?>