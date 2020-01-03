<?php
    require_once '../initializer.php';
    
    if( isset($_POST['Email']) ){
        if($_POST['IdAcquisto'] == '') {
            echo json_encode(array('result' => 'warning', 'message' => 'Errore Imprevisto segnalato ai tecnici'));
        } else if(strlen($_POST['codice']) != 3){
            echo json_encode(array('result' => 'warning', 'message' => 'CVC Errato'));
        }else if(!filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL)){
            echo json_encode(array('result' => 'warning', 'message' => 'Indirizzo Mail non Valido'));
        } else {
            $IdAcquisto = $_POST['IdAcquisto'];
            $Email = $_POST['Email'];
            $CVC = $_POST['codice'];
    
            $result = $dbh->doPaymentGuest($IdAcquisto, $Email, $CVC);
            if (count($result)!=0) {
                echo json_encode(array('result' => 'ok', 'message' => 'Pagamento avvenuto con successo', "id" => $result));
            } else {
                echo json_encode(array('result' => 'error', 'message' => 'Qualcosa non va, controlla i dati inseriti!'));
            }
        }

    }else{
        if($_POST['IdAcquisto'] == '') {
            echo json_encode(array('result' => 'warning', 'message' => 'Dati mancanti'));
        } else if(strlen($_POST['codice']) != 3){
            echo json_encode(array('result' => 'warning', 'message' => 'CVC Errato'));
        }else{
            $IdAcquisto = $_POST['IdAcquisto'];
            $codice = $_POST['codice'];
    
            $result = $dbh->doPaymentUser($IdAcquisto, $codice);
            if (count($result)!=0) {
                echo json_encode(array('result' => 'ok', 'message' => 'Pagamento avvenuto con successo'));
            } else {
                echo json_encode(array('result' => 'error', 'message' => 'Qualcosa non va, controlla i dati inseriti!'));
            }
        }

    }
?>