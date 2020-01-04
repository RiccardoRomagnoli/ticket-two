<?php
    require_once '../initializer.php';
    
    if(empty($_POST['azione']) || $_POST['azione'] == '') {
        echo json_encode(array('result' => 'warning', 'message' => 'Azione non corretta'));
    } else {
        switch($_POST['azione']) {
            case 'creaCart':
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
                break;
            
            case 'acquistoBiglietto':
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
                break;

            case 'modificaEvento':
                $idEvento = $_POST['idEvento'];
                $titolo = $_POST['titolo'];
                $dataInizio = $_POST['dataInizio'];
                $dataFine = $_POST['dataFine'];
                $descrizione = $_POST['descrizione'];
                $fotoLocation = $_POST['fotoLocation'];
                $nomeLuogo = $_POST['nomeLuogo'];

                $result = $dbh->modificaEvento($idEvento, $titolo, $fotoLocation, $nomeLuogo, $dataInizio, $dataFine, $descrizione);
                if ($result == true) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Modifica effettuata!'));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Modifica non riuscita!'));
                }
                break;

            case 'eliminaEvento':
                $idEvento = $_POST['idEvento'];
                $result = $dbh->eliminaEvento($idEvento);
                if ($result == true) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Eliminazione effettuata!'));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Eliminazione non riuscita!'));
                }
                break;
            
            case 'getInfoBiglietto':
                $idBiglietto = $_POST['idBiglietto'];
                $result = $dbh->getInfoBiglietto($idBiglietto);
                $biglietto = $result["0"];
                echo json_encode(array('nomeSezione' => $biglietto["NomeSezione"], 'dataInizio' => $biglietto["DataInizio"],
                                        'dataFine' => $biglietto["DataFine"], 'orarioBiglietto' => $biglietto["Orario"],
                                        'prezzoBiglietto' => $biglietto["Prezzo"], 'idTipoBiglietto' => $biglietto["IdTipoBiglietto"],
                                        'postiTotali' => $biglietto["PostiTotali"]
                                    ));
                break;

            case 'aggiungiEvento':
            
                break;

            case 'modificaSezione':
            
                break;

            case 'cancellaSezione':
                
                break;

            case 'aggiungiSezione':
            
                break;
        }
    }
?>