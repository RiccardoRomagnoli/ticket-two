<?php
    require_once '../initializer.php';
    
    if($_POST['azione'] == '') {
        echo json_encode(array('result' => 'warning', 'message' => 'Azione non corretta'));
    } elseif($_POST['azione'] == 'creaCart'){

        //guest senza cookie del carrello
        if(empty($_SESSION['idUtente']) && empty($_SESSION['carrelloaperto'])){
            $result = $dbh->creaCartGuest();
            setcookie("idAcquisto", $result, time() + (86400 * 30), "/");
            $_SESSION['carrelloaperto'] = $result;
            echo $result;
        }elseif(empty($_SESSION['idUtente']) && !empty($_SESSION['carrelloaperto'])){//guest con cookie
            echo $_SESSION['carrelloaperto'];
        }
        //utente senza carrello
        if(!empty($_SESSION['idUtente']) && $_SESSION['idUtente'] != '' && $_SESSION['carrelloaperto'] == ''){
            //crea cart
            $idUser = $_SESSION['idUtente'];
            $result = $dbh->creaCart($idUser);
            $_SESSION['carrelloaperto'] = $result[0]["IdAcquisto"]; 
            echo $result[0]["IdAcquisto"];
        }elseif(!empty($_SESSION['idUtente']) && $_SESSION['idUtente'] != '' && $_SESSION['carrelloaperto'] != ''){//utente con carrello
            echo $_SESSION['carrelloaperto']; 
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
                echo json_encode(array('result' => 'error', 'message' => 'Acquisto non riuscito!'));
            }
        }
    }
?>