<?php
    require_once '../initializer.php';
    if($_POST['action'] == 'update'){
        if($_POST['idPlace'] == '' || $_POST['name'] == '') {
            echo json_encode(array('result' => 'warning', 'message' => 'Parametri mancanti'));
        } else {
            $result = $dbh->updatePlace($_POST['idPlace'], $_POST['name'], $_POST['description']);
            if (count($result)==1) {
                echo json_encode(array('result' => 'ok', 'message' => 'Luogo modificato'));
            } else {
                echo json_encode(array('result' => 'error', 'message' => 'Si è verificato un errore'));
            }
        }
    } else if($_POST['action'] == 'delete'){
        if($_POST['idPlace'] == '') {
            echo json_encode(array('result' => 'warning', 'message' => 'Parametri mancanti'));
        } else {
            $result = $dbh->deletePlace($_POST['idPlace']);
            if (count($result)==1) {
                echo json_encode(array('result' => 'ok', 'message' => 'Luogo eliminato'));
            } else {
                echo json_encode(array('result' => 'error', 'message' => 'Si è verificato un errore'));
            }
        }
    } else {
        echo json_encode(array('result' => 'error', 'message' => 'Si è verificato un errore'));
    }
    
?>