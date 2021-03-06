<?php 
    $evento = $templateParams["evento"][0];
    $sessionData = '';
    //model per modifica cancellazione e aggiunta
    if($evento["IdUtente"] == $idutente){
        require_once 'template/pagineeventi/editEventModal.php';
        require_once 'template/pagineeventi/editBigliettoModal.php';
        require_once 'template/pagineeventi/editSectionModal.php';
        require_once 'template/pagineeventi/addBigliettoModal.php';
        require_once 'template/pagineeventi/addLuogoModal.php';
        require_once 'template/pagineeventi/addSectionModal.php';
        require_once 'template/pagineeventi/addArtistaModal.php';
    }
    require_once 'template/pagineeventi/addReportEventoModal.php';

    //dati utili per la pagina
    $sessionData .= '
        <input type="hidden" id="idEvento" value="' . $evento["IdEvento"] .'"/>
    ';

    //sezione del titolo
    $titleSection = '
        <div class="uk-grid uk-text-center">
            <div class="uk-panel uk-width-1-1">
                <h1 class="uk-float-left uk-margin-remove-bottom">' . $evento["TitoloEvento"] . '</h1>
                <a href="#modal-addReportEvento" uk-toggle class="uk-toggle uk-float-right">
                    <button class="openModalReportEvent uk-button uk-button-danger uk-button-primary">Segnala</button>
                </a>
                ';
    //controllo pulsante modifica se proprietario dell'evento
    if($evento["IdUtente"] == $idutente){
            $titleSection .= '
                <a href="#modal-editEvent" uk-toggle class="uk-toggle uk-float-right">
                    <button id="openModalEditEvent" class="uk-button uk-button-default uk-button-primary">Modifica</button>
                </a>
                ';
    }
    $titleSection .= '            
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
                        <a class="uk-flex uk-flex-center uk-accordion-title" href="#">Descrizione evento</a>
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
            $ticketTotali .= '
            <li>
                <a class="uk-accordion-title" href="#">' . $biglietto["NomeSezione"] . ' ' 
                . $biglietto["NomeBiglietto"] . ' ' . $biglietto["DataInizioBiglietto"] .' ' . $biglietto["Orario"] . '</a>
                    ' . $biglietto["PrezzoBiglietto"] . '€
                    <div class="uk-accordion-content">
                    ';
                    //controllo se l'organizzatore è proprietario dell'evento
                    if($evento["IdUtente"] == $idutente){
                        $ticketTotali .= '
                        <a href="#modal-editBiglietto" uk-toggle class="uk-toggle uk-float-right">
                            <button value="'. $biglietto["IdBiglietto"] .'" class="openModalEditTicket uk-icon-button uk-float-right uk-form-width-small" uk-icon="pencil"></button>
                        </a>    
                        ';
                    }
            $ticketTotali .= '
                    </div>
                <hr/>
            </li>';
        }
    }
    if($evento["IdUtente"] == $idutente){
        $ticketTotali .= '
        <li class="uk-flex uk-flex-center">
            <a href="#modal-addBiglietto" uk-toggle class="uk-toggle ">
               <button class="openModalAddTicket uk-icon-button uk-form-width-small" uk-icon="plus-circle"></button>
            </a>  
        </li>  
        ';
    }

    //zona dei biglietti abbonamento
    $abbonamentiTotali = "";
    foreach($templateParams["bigliettievento"] as $biglietto){ 
        if($biglietto["NomeBiglietto"] == "Abbonamento") {
            $abbonamentiTotali .= '
            <li>
                <a class="uk-accordion-title" href="#">' . $biglietto["NomeSezione"] . ' ' .
                    $biglietto["NomeBiglietto"] . ' Dal ' . $biglietto["DataInizioBiglietto"] . ' al '. $biglietto["DataFineBiglietto"] . '</a>
                    ' . $biglietto["PrezzoBiglietto"] . '€
                    <div class="uk-accordion-content">
                    ';
                    //controllo se l'organizzatore è proprietario dell'evento
                    if($evento["IdUtente"] == $idutente){
                        $abbonamentiTotali .= '
                    <a href="#modal-editBiglietto" uk-toggle class="uk-toggle uk-float-right">
                        <button value="'. $biglietto["IdBiglietto"] .'" class="openModalEditTicket uk-icon-button uk-float-right uk-form-width-small" uk-icon="pencil"></button>
                    </a>
                    ';
                    }
            $abbonamentiTotali .= '
                    </div>
                <hr/>
            </li>';
        }
    }

    if($evento["IdUtente"] == $idutente){
        $abbonamentiTotali .= '
        <li class="uk-flex uk-flex-center">
            <a href="#modal-addBiglietto" uk-toggle class="uk-toggle ">
               <button class="openModalAddTicket uk-icon-button uk-form-width-small" uk-icon="plus-circle"></button>
            </a>  
        </li>  
        ';
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