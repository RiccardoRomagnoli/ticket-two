<?php
    $evento = $templateParams["evento"][0];
    $sessionData = '
        <input type="hidden" id="idEvent" value="' . $evento["IdEvento"] .'">
    ';

    $titleSection = '';
    
    if($templateParams["eventoseguito"] == false){
        $titleSection .= '
        <div class="uk-grid uk-text-center">
            <div class="uk-panel uk-width-1-1">
                <h1 class="uk-float-left uk-margin-remove-bottom">' . $evento["TitoloEvento"] . '</h1>
                <button id="followBtn" class="uk-button uk-button-default uk-float-right">Segui</button>
            </div>
        </div>  
    ';
    } else {
        $titleSection .= '
        <div class="uk-grid uk-text-center">
            <div class="uk-panel uk-width-1-1">
                <h1 class="uk-float-left uk-margin-remove-bottom">' . $evento["TitoloEvento"] . '</h1>
                <button id="followBtn" class="uk-button uk-button-default uk-float-right">Non seguire più</button>
            </div>
        </div>
    ';
    }

    $photoSection = '
        <div class="uk-grid uk-margin-remove-top">
            <div class="uk-width-auto@m uk-width-xlarge@l">
                <img data-src="upload/'. $evento["Locandina"]. '" width="1800" height="1200" alt="" uk-img>
            </div>
        </div>
    ';
    $descriptionSection = '
        <div class="uk-grid uk-margin-remove-top">
            <div class="uk-width-1-1">
                <a href="./place.php?id='. $evento["IdLuogo"] .'" class="uk-float-left">' . $evento["NomeLuogo"] . '</a>
            </div>
            <div class="uk-width-1-1">
            ' . $evento["DataInizio"] . '-' . $evento["DataFine"] . '
            </div>
            <div class="uk-width-1-1">
                ' . $evento["EventoDescrizione"] . '
            </div>
        </div>
    ';
    $countTickets = 0;
    $ticketTotali = "";
    //per ogni biglietto dell'evento
    foreach($templateParams["bigliettievento"] as $biglietto){
        //se sono semplici ticket di giorni singoli
        if($biglietto["NomeBiglietto"] != "Abbonamento") {
            //controllo se posti finiti non li visualizzo
            $postiOccupati = $dbh->getTicketSezionePresi($biglietto["IdSezione"], $biglietto["DataInizioBiglietto"], 
                                                            $biglietto["DataFineBiglietto"], $biglietto["Orario"])[0]["PostiOccupati"];
            $postiLiberi = $biglietto["PostiTotali"] - $postiOccupati;
            
            if($postiLiberi > 0){
                $countTickets++;
                $ticketTotali .= '
                <li>
                    <a class="uk-accordion-title" href="#">' . $biglietto["NomeSezione"] . ' ' 
                    . $biglietto["NomeBiglietto"] . ' ' . $biglietto["DataInizioBiglietto"] . ' ' . $biglietto["Orario"] .'</a>
                        ' . $biglietto["PrezzoBiglietto"] . '€
                        <div class="uk-accordion-content">
                            <input type="hidden" id="idBiglietto'. $countTickets .'" value="'. $biglietto["IdBiglietto"] .'">
                            <select id="numeroTicket'. $countTickets .'" class="uk-select uk-float-left uk-form-width-small">';
                            for($i = 1 ; $i <= 4 && $i <= $postiLiberi; $i++){
                                $ticketTotali .= '
                                <option value="'. $i .'">'. $i .'</option>
                                ';
                            }
                $ticketTotali .= '
                            </select>
                            <button id="aggiungiTicket'. $countTickets .'" class="uk-icon-button uk-float-right uk-form-width-small" uk-icon="cart"></button>
                        </div>
                    <hr/>
                </li>';
            }
        }
    }
    $countAbbonamenti = 0;
    $abbonamentiTotali = "";
    foreach($templateParams["bigliettievento"] as $biglietto){ 
        if($biglietto["NomeBiglietto"] == "Abbonamento") {
            $postiOccupati = $dbh->getAbbonamentoSezionePresi($biglietto["IdSezione"], $biglietto["DataInizioBiglietto"], 
                                                            $biglietto["DataFineBiglietto"])[0]["PostiOccupati"];
            $postiLiberi = $biglietto["PostiTotali"] - $postiOccupati;
            
            if($postiLiberi > 0){
                $countAbbonamenti++;
                $abbonamentiTotali .= '
                <li>
                    <a class="uk-accordion-title" href="#">' . $biglietto["NomeSezione"] . ' ' .
                        $biglietto["NomeBiglietto"] . ' Dal ' . $biglietto["DataInizioBiglietto"] . ' al '. $biglietto["DataFineBiglietto"] .'</a>
                        ' . $biglietto["PrezzoBiglietto"] . '€
                    <div class="uk-accordion-content">
                        <input type="hidden" id="idAbbonamento'. $countAbbonamenti .'" value="'. $biglietto["IdBiglietto"] .'">
                        <select id="numeroAbbonamento'. $countAbbonamenti .'" class="uk-select uk-float-left uk-form-width-small">';
                        for($i = 1 ; $i <= 4 && $i <= $postiLiberi; $i++){
                            $abbonamentiTotali .= '
                            <option value="'. $i .'">'. $i .'</option>
                            ';
                        }
                $abbonamentiTotali .='
                        </select>
                        <button id="aggiungiAbbonamento'. $countAbbonamenti .'" class="uk-icon-button uk-float-right uk-form-width-small" uk-icon="cart"></button>
                    </div>
                    <hr/>
                </li>';
            }
        }
    }
    $ticketSection = '
        <input type="hidden" id="nTickets" value="'. $countTickets .'">
        <input type="hidden" id="nAbbonamenti" value="'. $countAbbonamenti .'">
        <div class="uk-grid uk-margin-remove-top">
            <div class="uk-width-1-1">
                <ul uk-tab>
                    <li class="uk-active uk-width-1-2"><a href="#">Biglietti</a></li>
                    <li class="uk-width-1-2"><a href="#">Abbonamenti</a></li>
                </ul>
                <ul class="uk-switcher uk-margin">
                    <li>
                        <ul uk-accordion>
                            ' . $ticketTotali . '
                        </ul>
                    </li>
                    <li>
                        <ul uk-accordion>
                        ' . $abbonamentiTotali . '
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    ';
?>