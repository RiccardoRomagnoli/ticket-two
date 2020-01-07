<?php
    require_once '../initializer.php';
    
    if(empty($_POST['azione']) || $_POST['azione'] == '') {
        echo json_encode(array('result' => 'warning', 'message' => 'Azione non corretta'));
    } else {
        switch($_POST['azione']) {
            //post ricerca
            case 'ricercaArtisti':  
                $testoRicerca = $_POST["testoRicerca"];
                $artisti = $dbh->ricercaArtisti($testoRicerca);
                $result = array();
                foreach ($artisti as $artista) {
                    $tmp = array($artista["IdArtista"],$artista["Nome"]);
                    $result[] = $tmp;
                }
                echo json_encode(array('data' => $result));
            break;

            case 'ricercaLuoghi':  
                $testoRicerca = $_POST["testoRicerca"];
                $luoghi = $dbh->ricercaLuoghi($testoRicerca);
                $result = array();
                foreach ($luoghi as $luogo) {
                    $tmp = array($luogo["IdLuogo"],$luogo["Nome"]);
                    $result[] = $tmp;
                }
                echo json_encode(array('data' => $result));
            break;

            case 'ricercaEventi':  
                $testoRicerca = $_POST["testoRicerca"];
                $eventi = $dbh->ricercaEventi($testoRicerca);
                $result = array();
                foreach ($eventi as $evento) {
                    $tmp = array($evento["IdEvento"],$evento["Titolo"]);
                    $result[] = $tmp;
                }
                echo json_encode(array('data' => $result));
            break;
        }
    }
?>