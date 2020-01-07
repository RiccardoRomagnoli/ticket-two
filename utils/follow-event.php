<?php
    require_once '../initializer.php';
    
    if($_POST['idEvento'] == '') {
        echo json_encode(array('result' => 'warning', 'message' => 'Username o evento non corretto'));
    } elseif(isSessionActive() == true){
        $idUser = $_SESSION['idUtente'];
        $idEvento = $_POST['idEvento'];
        if($_POST['follow'] == "true"){
            $result = $dbh->follow($idUser, $idEvento);
            if ($result == true) {
                echo json_encode(array('result' => 'ok', 'message' => 'Follow effettuato con successo!'));
            } else {
                echo json_encode(array('result' => 'error', 'message' => 'Qualcosa non va!'));
            }
        } else {
            $result = $dbh->unFollow($idUser, $idEvento);
            if ($result == true) {
                echo json_encode(array('result' => 'ok', 'message' => 'Unfollow effettuato con successo!'));
            } else {
                echo json_encode(array('result' => 'error', 'message' => 'Qualcosa non va!'));
            }
        }
    }
?>