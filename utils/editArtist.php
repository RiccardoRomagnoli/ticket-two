<?php
    require_once '../initializer.php';
    if(($_POST['idArtist'] == '') || $_POST['name'] == '') {
        echo json_encode(array('result' => 'warning', 'message' => 'Parametri mancanti'));
    } else {
        $result = $dbh->updateArtist($_POST['idArtist'], $_POST['name'], $_POST['description'], $_POST['foto']);
        if (count($result)==1) {
            echo json_encode(array('result' => 'ok', 'message' => 'Artista modificato'));
        } else {
            echo json_encode(array('result' => 'error', 'message' => 'Si è verificato un errore'));
        }
    }
?>