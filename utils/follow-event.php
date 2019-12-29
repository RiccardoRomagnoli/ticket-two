<?php
    require_once '../initializer.php';
    
    if(($_POST['idUser'] == '') || $_POST['idEvent'] == '') {
        echo json_encode(array('result' => 'warning', 'message' => 'Username o evento non corretto'));
    } else {
        $idUser = $_POST['idUser'];
        $idEvent = $_POST['idEvent'];
        if($_POST['follow'] == "true"){
            $result = $dbh->follow($idUser, $idEvent);
            if ($result == true) {
                echo json_encode(array('result' => 'ok', 'message' => 'Follow effettuato con successo!'));
            } else {
                echo json_encode(array('result' => 'error', 'message' => 'Qualcosa non va!'));
            }
        } else {
            $result = $dbh->unFollow($idUser, $idEvent);
            if ($result == true) {
                echo json_encode(array('result' => 'ok', 'message' => 'Unfollow effettuato con successo!'));
            } else {
                echo json_encode(array('result' => 'error', 'message' => 'Qualcosa non va!'));
            }
        }
    }
?>