<?php
    require_once '../initializer.php';
    if(($_POST['idPlace'] == '') || $_POST['idUser'] == '' || $_POST['action'] == '') {
        echo json_encode(array('result' => 'warning', 'message' => 'Parametri mancanti'));
    } else {
        if($_POST['action'] == 'follow'){
            if(!$dbh->checkIfUserFollowPlace($_POST['idUser'], $_POST['idPlace'])){
                $result = $dbh->insertFollowPlace($_POST['idUser'], $_POST['idPlace']);
                if (count($result)==1) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Ora segui questo posto'));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Si è verificato un errore'));
                }
            } else {
                echo json_encode(array('result' => 'ok', 'message' => 'Segui già questo posto'));
            }
            
        } else if($_POST['action'] == 'unfollow'){
            if($dbh->checkIfUserFollowPlace($_POST['idUser'], $_POST['idPlace'])){
                $result = $dbh->deleteFollowPlace($_POST['idUser'], $_POST['idPlace']);
                if (count($result)==1) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Non segui più questo posto'));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Si è verificato un errore'));
                }
            } else {
                echo json_encode(array('result' => 'ok', 'message' => 'Non seguivi già questo posto'));
            }
        } else {
            echo json_encode(array('result' => 'warning', 'message' => 'Parametro action errato'));
        }
    }
?>