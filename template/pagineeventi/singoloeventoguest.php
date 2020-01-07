<?php
    $evento = $templateParams["evento"][0];

    //dati utili per la pagina
    $sessionData = '
        <input type="hidden" id="idEvento" value="' . $evento["IdEvento"] .'">
        ';

    //sezione del titolo
    $titleSection = '
        <div class="uk-grid uk-text-center">
            <div class="uk-panel uk-width-1-1">
                <h1 class="uk-float-left uk-margin-remove-bottom">' . $evento["TitoloEvento"] . '</h1>
            </div>
        </div>  
        ';

    //sezione della foto
    $photoSection = '
        <div class="uk-grid uk-margin-remove-top">
            <div class="uk-width-auto@m uk-width-xlarge@l">
                <img data-src="upload/'. $evento["Locandina"]. '" width="1800" height="1200" alt="Locandina Evento" uk-img>
            </div>
        </div>
    ';

    $artistiTotali = "";
    $categorieTotali = "";
    foreach($templateParams["artistievento"] as $artista){
        $artistiTotali .= '<a href="./artist.php?id=' . $artista["IdArtista"] . '">' . $artista["Nome"] . '</a> ';
    }

    foreach($templateParams["categorieevento"] as $categoria){
        $categorieTotali .= $categoria["Nome"] . ' ';
    }

    //sezione della descrizione dell'evento
    $descriptionSection = '
            <div class="uk-grid uk-margin-remove-top">
            <div class="uk-width-1-1">
            ' . $evento["DataInizio"] . '-' . $evento["DataFine"] . '
            </div>
            <div class="uk-width-1-1">
                ' . $artistiTotali . '
            </div>
            <div class="uk-width-1-1">
                ' . $categorieTotali . '
            </div>
            <div class="uk-width-1-1">
                <a href="./place.php?id='. $evento["IdLuogo"] .'" class="uk-float-left">' . $evento["NomeLuogo"] . '</a>
            </div>
            <div class="uk-width-1-1">
                <ul uk-accordion>
                    <li>
                        <a class="uk-accordion-title" href="#">Descrizione evento</a>
                        <div class="uk-accordion-content">
                        ' . $evento["EventoDescrizione"] . '    
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    ';

    //zona dei biglietti singoli interi e ridotti
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
                $ticketTotali .= '
                <li>
                    <a class="uk-accordion-title" href="#">' . $biglietto["NomeSezione"] . ' ' 
                    . $biglietto["NomeBiglietto"] . ' ' . $biglietto["DataInizioBiglietto"] . ' ' . $biglietto["Orario"] .'</a>
                        ' . $biglietto["PrezzoBiglietto"] . '€
                        <div class="uk-accordion-content">
                            <select id="numeroTicket'. $biglietto["IdBiglietto"] .'" class="uk-select uk-float-left uk-form-width-small">';
                            for($i = 1 ; $i <= 4 && $i <= $postiLiberi; $i++){
                                $ticketTotali .= '
                                <option value="'. $i .'">'. $i .'</option>
                                ';
                            }
                $ticketTotali .= '
                            </select>
                            <button value="'. $biglietto["IdBiglietto"] .'" class="buyTicket uk-icon-button uk-float-right uk-form-width-small" uk-icon="cart"></button>
                        </div>
                    <hr/>
                </li>';
            }
        }
    }

    //zona dei biglietti abbonamento
    $abbonamentiTotali = "";
    foreach($templateParams["bigliettievento"] as $biglietto){ 
        if($biglietto["NomeBiglietto"] == "Abbonamento") {
            $postiOccupati = $dbh->getAbbonamentoSezionePresi($biglietto["IdSezione"], $biglietto["DataInizioBiglietto"], 
                                                            $biglietto["DataFineBiglietto"])[0]["PostiOccupati"];
            $postiLiberi = $biglietto["PostiTotali"] - $postiOccupati;
            
            if($postiLiberi > 0){
                $abbonamentiTotali .= '
                <li>
                    <a class="uk-accordion-title" href="#">' . $biglietto["NomeSezione"] . ' ' .
                        $biglietto["NomeBiglietto"] . ' Dal ' . $biglietto["DataInizioBiglietto"] . ' al '. $biglietto["DataFineBiglietto"] .'</a>
                        ' . $biglietto["PrezzoBiglietto"] . '€
                    <div class="uk-accordion-content">
                        <select id="numeroTicket'. $biglietto["IdBiglietto"] .'" class="uk-select uk-float-left uk-form-width-small">';
                        for($i = 1 ; $i <= 4 && $i <= $postiLiberi; $i++){
                            $abbonamentiTotali .= '
                            <option value="'. $i .'">'. $i .'</option>
                            ';
                        }
                $abbonamentiTotali .='
                        </select>
                        <button value="'. $biglietto["IdBiglietto"] .'" class="buyTicket uk-icon-button uk-float-right uk-form-width-small" uk-icon="cart"></button>
                    </div>
                    <hr/>
                </li>';
            }
        }
    }
    
    //sezione dei biglietti, includendo i pezzi creati sopra
    $ticketSection = '
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