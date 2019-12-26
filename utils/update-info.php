<?php
    require_once '../initializer.php';
    
    if(($_POST['Email'] == '') || ($_POST['Password']=='') || ($_POST['NewPassword']=='') || ($_POST['Nome']=='') || ($_POST['Cognome']=='')) {
        echo json_encode(array('result' => 'warning', 'message' => 'Parametri mancanti'));
    } else if(!($_POST['Password'] == $_POST['NewPassword'])){
        echo json_encode(array('result' => 'warning', 'message' => 'Le password non coincidono'));
    } else if(!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)){
        echo json_encode(array('result' => 'warning', 'message' => 'Indirizzo Mail non Valido'));
    } else {
        $Nome = $_POST['Nome'];
        $Cognome = $_POST['Cognome'];
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];
        $NewPassword = $_POST['NewPassword'];

        $result = $dbh->updateUser($Nome, $Cognome, $Email, $Password, $_SESSION["idUtente"]);
        if (count($result)==1) {
            echo json_encode(array('result' => 'ok', 'message' => 'Registrazione Effettuata con successo!'));
            updateSession($Nome, $Cognome, $Email);
        } else {
            echo json_encode(array('result' => 'error', 'message' => 'Qualcosa non va, Non siamo riusciti a registrarti!'));
        }
    }
?>