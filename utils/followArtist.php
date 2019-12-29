<?php
    require_once '../initializer.php';
    if(($_POST['idArtist'] == '') || $_POST['idUser'] == '' || $_POST['action'] == '') {
        echo json_encode(array('result' => 'warning', 'message' => 'Parametri mancanti'));
    } else {
        if($_POST['action'] == 'follow'){
            if(!$dbh->checkIfUserFollowArtist($_POST['idUser'], $_POST['idArtist'])){
                $result = $dbh->insertFollowArtist($_POST['idUser'], $_POST['idArtist']);
                if (count($result)==1) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Ora segui questo artista'));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Si è verificato un errore'));
                }
            } else {
                echo json_encode(array('result' => 'ok', 'message' => 'Segui già questo artista'));
            }
            
        } else if($_POST['action'] == 'unfollow'){
            if($dbh->checkIfUserFollowArtist($_POST['idUser'], $_POST['idArtist'])){
                $result = $dbh->deleteFollowArtist($_POST['idUser'], $_POST['idArtist']);
                if (count($result)==1) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Non segui più questo artista'));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Si è verificato un errore'));
                }
            } else {
                echo json_encode(array('result' => 'ok', 'message' => 'Non seguivi già questo artista'));
            }
        } else {
            echo json_encode(array('result' => 'warning', 'message' => 'Parametro action errato'));
        }
    }
?>