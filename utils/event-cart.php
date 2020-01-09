<?php
    require_once '../initializer.php';
    
    if(empty($_POST['azione']) || $_POST['azione'] == '') {
        echo json_encode(array('result' => 'warning', 'message' => 'Azione non corretta'));
    } else {
        switch($_POST['azione']) {

            //post creazione cart
            case 'creaCart':
                if(empty($_SESSION['idUtente'])){
                    if(empty($_COOKIE['carrello'])){
                        $result = $dbh->creaCartGuest();
                        setcookie("idAcquisto", $result, time() + (86400 * 30), "/");
                        echo $result;
                    }else{
                        echo $_COOKIE['carrello'];
                    }
                } else {
                    if(empty($_SESSION['carrello'])){
                        $idUser = $_SESSION['idUtente'];
                        $result = $dbh->creaCart($idUser);
                        $_SESSION['carrello'] = $result[0]["IdAcquisto"];
                        echo $result[0]["IdAcquisto"];
                    }else{
                        echo $_SESSION['carrello']; 
                    }
                }
            break;

            //post acquisto biglietto
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

            //post aggiunta al db
            case 'aggiungiArtista':
                $nomeArtista = $_POST['nomeArtista'];
                $descrizioneArtista = $_POST['descrizioneArtista'];
                $result = 0;
                $msg = "";

                if(!empty($_FILES["fotoArtista"])){
                    list($result, $msg) = uploadImage(UPLOAD_DIR, $_FILES["fotoArtista"]);
                } else {
                    $result = 1;
                    $msg = "artist_default.jpg";
                }

                if($result != 0){
                    $result = $dbh->aggiungiArtista($nomeArtista, $descrizioneArtista, $msg);
                    if (!empty($result)) {
                        echo json_encode(array('result' => 'ok', 'message' => 'Aggiunta effettuata!', 'idArtista' => $result[0], 'nomeArtista' => $result[1]));
                    } else {
                        echo json_encode(array('result' => 'error', 'message' => 'Aggiunta non riuscita!'));
                    }
                } else {
                        echo json_encode(array('result' => 'error', 'message' => $msg));
                }
            break;

            case 'aggiungiEvento':
                $titolo = $_POST['titolo'];
                $dataInizio = $_POST['dataInizio'];
                $dataFine = $_POST['dataFine'];
                $descrizione = $_POST['descrizione'];
                $idUtente = $_SESSION['idUtente'];
                $result = 0;
                $msg = "";
                if(!empty($_FILES["fotoLocation"])){
                    list($result, $msg) = uploadImage("." . UPLOAD_DIR, $_FILES["fotoLocation"]);
                } else {
                    $result = 1;
                    $msg = "event_default.jpg";
                }
                $idLuogo = $_POST['idLuogo'];
                if($result != 0){
                    $result = $dbh->aggiungiEvento($titolo, $msg, $idLuogo, $dataInizio, $dataFine, $descrizione, $idUtente);
                    if (!empty($result)) {
                        echo json_encode(array('result' => 'ok', 'message' => 'Aggiunta effettuata!', 'idEvento' => $result));
                    } else {
                        echo json_encode(array('result' => 'error', 'message' => 'Aggiunta non riuscita!'));
                    }
                } else {
                    echo json_encode(array('result' => 'error', 'message' => $msg));
                }
            break;

            case 'aggiungiNotifica':
                $idEvento = $_POST["idEvento"];
                $dbh->aggiungiNotifica($idEvento);
            break;

            case 'aggiungiBiglietto':
                $idSezioneEvento = $_POST['idSezioneEvento'];
                $dataInizioBiglietto = $_POST['dataInizioBiglietto'];
                $dataFineBiglietto = $_POST['dataFineBiglietto'];
                $idTipoBiglietto = $_POST['idTipoBiglietto'];
                $orarioBiglietto = $_POST['orarioBiglietto'];
                $prezzoBiglietto= $_POST['prezzoBiglietto'];

                $result = $dbh->addBiglietto($idSezioneEvento, $dataInizioBiglietto, $dataFineBiglietto, $idTipoBiglietto, $orarioBiglietto, $prezzoBiglietto);
                if ($result == true) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Modifica effettuata!'));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Modifica non riuscita!'));
                }
            break;

            case 'aggiungiCategoriaEvento':
                $idEvento = $_POST['idEvento'];
                $idCategoria = $_POST['idCategoria'];
                $dbh->aggiungiCategoriaEvento($idEvento, $idCategoria);
            break;

            case 'aggiungiArtistaEvento':
                $idEvento = $_POST['idEvento'];
                $idArtista = $_POST['idArtista'];
                $dbh->aggiungiArtistaEvento($idEvento, $idArtista);
            break;

            case 'aggiungiSezione':
                $idEvento = $_POST['idEvento'];
                $nomeSezione = $_POST['nomeSezione'];
                $postiTotali = $_POST['postiTotali'];
                $result = $dbh->aggiungiSezione($idEvento, $nomeSezione, $postiTotali);
                if (!empty($result)) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Aggiunta effettuata!', 'idSezione' => $result[0], 'nomeSezione' => $result[1]));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Aggiunta non riuscita!'));
                }
            break;
            
            case 'aggiungiReportEvento':
                $idEvento = $_POST['idEvento'];
                $descrizioneReport = $_POST['descrizioneReport'];
                $idUtente = $_SESSION['idUtente'];
                $result = $dbh->aggiungiReportEvento($idEvento, $idUtente, $descrizioneReport);
                if (!empty($result)) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Segnalazione effettuata!'));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Segnalazione non riuscita!'));
                }
            break;

            case 'aggiungiLuogo':
                $idCitta = $_POST['idCitta'];
                $nomeLuogo = $_POST['nomeLuogo'];
                $descrizioneLuogo = $_POST['descrizioneLuogo'];

                $result = $dbh->addLuogo($idCitta, $nomeLuogo, $descrizioneLuogo);
                if (!empty($result)) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Luogo aggiunto!', 'idLuogo' => $result[0], 'nomeLuogo' => $result[1]));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Luogo non aggiunto!'));
                }            
            break;

            //post get info    
            case 'getInfoEvento':
                $idEvento = $_POST['idEvento'];
                $result = $dbh->getEventByIdEvento($idEvento);
                $evento = $result["0"];
                echo json_encode(array('nomeEvento' => $evento["TitoloEvento"], 'dataInizioEvento' => $evento["DataInizio"],
                                        'dataFineEvento' => $evento["DataFine"], 'descrizioneEvento' => $evento["EventoDescrizione"]
                                    ));
            break;

            case 'getInfoSezione':
                $idSezione = $_POST['idSezione'];
                $result = $dbh->getInfoSezione($idSezione);
                $sezione = $result[0];
                echo json_encode(array('idSezione' => $sezione["IdSezione"], 'nomeSezione' => $sezione["Nome"],
                    'postiTotali' => $sezione["PostiTotali"]
                    ));
            break;   

            case 'getInfoBiglietto':
                    $idBiglietto = $_POST['idBiglietto'];
                    $result = $dbh->getInfoBiglietto($idBiglietto);
                    $biglietto = $result["0"];
                    echo json_encode(array('idSezioneEvento' => $biglietto["IdSezioneEvento"], 'dataInizio' => $biglietto["DataInizio"],
                                            'dataFine' => $biglietto["DataFine"], 'orarioBiglietto' => $biglietto["Orario"],
                                            'prezzoBiglietto' => $biglietto["Prezzo"], 'idTipoBiglietto' => $biglietto["IdTipoBiglietto"]
                                        ));
            break;

            case 'getLuogoEvento':    
                    $idEvento = $_POST['idEvento'];
                    $result = $dbh-> getLuogoEvento($idEvento);
                    echo json_encode(array_values($result));
            break;

            case 'getLuoghiNonEvento':    
                $idEvento = $_POST['idEvento'];
                $result = $dbh->getLuoghiNonEvento($idEvento);
                echo json_encode(array_values($result));
            break;

            case 'getArtistiEvento':    
                    $idEvento = $_POST['idEvento'];
                    $result = $dbh-> getEventArtistsByIdEvento($idEvento);
                    echo json_encode(array_values($result));           
            break;

            case 'getArtistiNonEvento':    
                $idEvento = $_POST['idEvento'];
                $result = $dbh->getArtistiNonEvento($idEvento);
                echo json_encode(array_values($result));          
            break;
            
            case 'getCategorieEvento':    
                $idEvento = $_POST['idEvento'];
                $result = $dbh-> getEventCategoriesByIdEvento($idEvento);
                echo json_encode(array_values($result));
            
            break;

            case 'getCategorieNonEvento':    
                $idEvento = $_POST['idEvento'];
                $result = $dbh->getCategorieNonEvento($idEvento);
                echo json_encode(array_values($result)); 
            break;

            case 'getSezioneBiglietto':    
                $idBiglietto = $_POST['idBiglietto'];
                $result = $dbh-> getSezioneBiglietto($idBiglietto);
                echo json_encode(array_values($result));
            break;

            case 'getSezioneNonBiglietto':    
                $idBiglietto = $_POST['idBiglietto'];
                $idEvento = $_POST['idEvento'];
                $result = $dbh->getSezioneNonBiglietto($idBiglietto, $idEvento);
                echo json_encode(array_values($result));
            break;
            
            case 'getTipoBigliettoBiglietto':    
                $idBiglietto = $_POST['idBiglietto'];
                $result = $dbh-> getTipoBiglietto($idBiglietto);
                echo json_encode(array_values($result));
            break;

            case 'getTipoBigliettoNonBiglietto':    
                $idBiglietto = $_POST['idBiglietto'];
                $result = $dbh->getTipoNonBiglietto($idBiglietto);
                echo json_encode(array_values($result));
            break;

            case 'getRegioni':
                $result = $dbh->getRegione();
                echo json_encode(array_values($result));   
            break;

            case 'getProvince':
                $idRegione = $_POST['idRegione'];
                $result = $dbh->getProvinciaFromRegione($idRegione);
                echo json_encode(array_values($result));            
            break;

            case 'getCitta':
                $idProvincia = $_POST['idProvincia'];
                $result = $dbh->getCittaFromProvincia($idProvincia);
                echo json_encode(array_values($result));            
            break;
             
            case 'getSezioniEvento':
                $idEvento = $_POST['idEvento'];
                $result = $dbh->getSezioni($idEvento);
                echo json_encode(array_values($result));       
            break;

            case 'getTipiBiglietto':
                $result = $dbh->getTipoBiglietti();
                echo json_encode(array_values($result));       
            break;

            //post di edit
            case 'modificaEvento':
                $idEvento = $_POST['idEvento'];
                $titolo = $_POST['titolo'];
                $dataInizio = $_POST['dataInizio'];
                $dataFine = $_POST['dataFine'];
                $descrizione = $_POST['descrizione'];
                $result = 0;
                $msg = "";
                if(!empty($_FILES["fotoLocation"])){
                    list($result, $msg) = uploadImage("." . UPLOAD_DIR, $_FILES["fotoLocation"]);
                }
                $idLuogo = $_POST['idLuogo'];
                if($result != 0){
                    $result = $dbh->modificaEvento($idEvento, $titolo, $msg, $idLuogo, $dataInizio, $dataFine, $descrizione);
                    if ($result == true) {
                        echo json_encode(array('result' => 'ok', 'message' => 'Modifica effettuata!'));
                    } else {
                        echo json_encode(array('result' => 'error', 'message' => 'Modifica non riuscita!'));
                    }
                } else {
                    $result = $dbh->modificaEventoNoImage($idEvento, $titolo, $idLuogo, $dataInizio, $dataFine, $descrizione);
                    if ($result == true) {
                        echo json_encode(array('result' => 'ok', 'message' => 'Modifica effettuata!'));
                    } else {
                        echo json_encode(array('result' => 'error', 'message' => 'Modifica non riuscita!'));
                    }
                }
            break;

            case 'modificaBiglietto':
                $idBiglietto = $_POST['idBiglietto'];
                $idSezioneEvento = $_POST['idSezioneEvento'];
                $dataInizioBiglietto = $_POST['dataInizioBiglietto'];
                $dataFineBiglietto = $_POST['dataFineBiglietto'];
                $idTipoBiglietto = $_POST['idTipoBiglietto'];
                $orarioBiglietto = $_POST['orarioBiglietto'];
                $prezzoBiglietto= $_POST['prezzoBiglietto'];

                $result = $dbh->modificaBiglietto($idBiglietto, $idSezioneEvento, $dataInizioBiglietto, $dataFineBiglietto, $idTipoBiglietto, $orarioBiglietto, $prezzoBiglietto);
                if ($result == true) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Modifica effettuata!'));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Modifica non riuscita!'));
                }
            break;

            case 'modificaSezione':
                $idSezione = $_POST['idSezione'];
                $nomeSezione = $_POST['nomeSezione'];
                $postiTotali = $_POST['postiTotali'];
                $result = $dbh->modificaSezione($idSezione, $nomeSezione, $postiTotali);
                if ($result == true) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Modifica effettuata!'));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Modifica non riuscita!'));
                }
            break;

            //post di eliminazione
            case 'eliminaEvento':
                $idEvento = $_POST['idEvento'];
                $result = $dbh->eliminaEvento($idEvento);
                if ($result == true) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Eliminazione effettuata!'));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Eliminazione non riuscita!'));
                }
            break;

            case 'cancellaCategorieEvento':
                $idEvento = $_POST['idEvento'];
                $dbh->cancellaCategorieEvento($idEvento);
            break;

            case 'cancellaArtistiEvento':
                $idEvento = $_POST['idEvento'];
                $dbh->cancellaArtistiEvento($idEvento);
            break;

            case 'eliminaBiglietto':
                $idBiglietto = $_POST['idBiglietto'];
                $result = $dbh->eliminaBiglietto($idBiglietto);
                if ($result == true) {
                    echo json_encode(array('result' => 'ok', 'message' => 'Eliminazione effettuata!'));
                } else {
                    echo json_encode(array('result' => 'error', 'message' => 'Eliminazione non riuscita!'));
                }
            break;
        }
    }
?>