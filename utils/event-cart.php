<?php
    require_once '../initializer.php';
    
    if($_POST['azione'] == '') {
        echo json_encode(array('result' => 'warning', 'message' => 'Azione non corretta'));
    } elseif($_POST['azione'] == 'creaCart'){
        if($_POST['idUser'] == '') {
            echo json_encode(array('result' => 'warning', 'message' => 'Username non corretto'));
        } else {
            //crea cart
            $idUser = $_POST['idUser'];
            $result = $dbh->creaCart($idUser);
            echo $result[0]["IdAcquisto"];
        }
    } elseif($_POST['azione'] == 'acquistoBiglietto'){
        if($_POST['idCart'] == '' || $_POST['idBiglietto'] == ''){
            echo json_encode(array('result' => 'warning', 'message' => 'Cart o biglietto non corretto'));
        } else {
            $idCart = $_POST['idCart'];
            $idBiglietto = $_POST['idBiglietto'];
            $result = $dbh->creaRigaAcquisto($idCart, $idBiglietto);
            if ($result == true) {
                echo json_encode(array('result' => 'ok', 'message' => 'Acquisto aggiunto al carrello'));
            } else {
                echo json_encode(array('result' => 'error', 'message' => 'Qualcosa non va!'));
            }
        }
    }
?>