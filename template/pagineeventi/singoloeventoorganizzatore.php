<?php 
    $evento = $templateParams["evento"][0];
    $sessionData = '';
    
    require_once 'template/pagineeventi/editEventModal.php';
    require_once 'template/pagineeventi/editSectionModal.php';

    $sessionData .= '
        <input type="hidden" id="idEvent" value="' . $evento["IdEvento"] .'">
    ';

    $titleSection = '
        <div class="uk-grid uk-text-center">
            <div class="uk-panel uk-width-1-1">
                <h1 class="uk-float-left uk-margin-remove-bottom">' . $evento["TitoloEvento"] . '</h1>
                ';

    if($evento["IdUtente"] == $idutente){
            $titleSection .= '
                <a href="#modal-editEvent" uk-toggle class="uk-toggle uk-float-right">
                <button class="uk-button uk-button-default uk-button-primary">Modifica</button>
                </a>
                ';
    }
    $titleSection .= '            
            </div>
        </div>  
        ';

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
    foreach($templateParams["bigliettievento"] as $biglietto){
        if($biglietto["NomeBiglietto"] != "Abbonamento") {
            $ticketTotali .= '
            <li>
                <a class="uk-accordion-title" href="#">' . $biglietto["NomeSezione"] . ' ' 
                . $biglietto["NomeBiglietto"] . ' ' . $biglietto["DataInizioBiglietto"] .'</a>
                    ' . $biglietto["PrezzoBiglietto"] . '€
                    <div class="uk-accordion-content">
                    ';
                    if($evento["IdUtente"] == $idutente){
                        $ticketTotali .= '
                        <a href="#modal-editBiglietto" uk-toggle class="uk-toggle uk-float-right">
                            <button value="'. $biglietto["IdBiglietto"] .'" class="editTicket uk-icon-button uk-float-right uk-form-width-small" uk-icon="pencil"></button>
                        </a>    
                        ';
                    }
            $ticketTotali .= '
                    </div>
                <hr/>
            </li>';
        }
    }
$countAbbonamenti = 0;
$abbonamentiTotali = "";
    foreach($templateParams["bigliettievento"] as $biglietto){ 
        if($biglietto["NomeBiglietto"] == "Abbonamento") {
            $countAbbonamenti++;
            $abbonamentiTotali .= '
            <li>
                <a class="uk-accordion-title" href="#">' . $biglietto["NomeSezione"] . ' ' .
                    $biglietto["NomeBiglietto"] . ' ' . $biglietto["DataInizioBiglietto"] . '</a>
                    ' . $biglietto["PrezzoBiglietto"] . '€
                    <div class="uk-accordion-content">
                    ';
                    if($evento["IdUtente"] == $idutente){
                        $abbonamentiTotali .= '
                    <a href="#modal-editBiglietto" uk-toggle class="uk-toggle uk-float-right">
                        <button value="'. $biglietto["IdBiglietto"] .'" class="editTicket uk-icon-button uk-float-right uk-form-width-small" uk-icon="pencil"></button>
                    </a>
                    ';
                    }
            $abbonamentiTotali .= '
                    </div>
                <hr/>
            </li>';
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