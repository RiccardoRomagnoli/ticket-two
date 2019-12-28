<?php
    $evento = $templateParams["evento"][0];
    $titleSection = '
        <div class="uk-grid uk-text-center">
            <div class="uk-panel uk-width-1-1">
                <a href="#" class="uk-float-left uk-margin-small-left">' . $evento["TitoloEvento"] . '</a>
                <button class="uk-button uk-button-default uk-float-right uk-margin-small-right">Segui</button>
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
                <a href="#" class="uk-float-left">' . $evento["NomeLuogo"] . '</a>
            </div>
            <div class="uk-width-1-1">
            ' . $evento["DataInizio"] . '-' . $evento["DataFine"] . '
            </div>
            <div class="uk-width-1-1">
                ' . $evento["EventoDescrizione"] . '
            </div>
        </div>
    ';
$ticketTotali = "";
    foreach($templateParams["bigliettievento"] as $biglietto){ 
        if($biglietto["NomeBiglietto"] != "Abbonamento") {
            $ticketTotali .= '
            <li>
                <a class="uk-accordion-title" href="#">' . $biglietto["NomeSezione"] . ' ' 
                . $biglietto[" "] . ' ' . $biglietto["DataInizioBiglietto"] .'</a>
                    ' . $biglietto["PrezzoBiglietto"] . '€
                <div class="uk-accordion-content">
                    <form class="uk-grid-small" uk-grid>
                        <fieldset class="uk-fieldset uk-width-1-1">
                            <select class="uk-select uk-float-left uk-form-width-small">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            <button class="uk-icon-button uk-float-right uk-form-width-small" uk-icon="cart"></button>
                        </fieldset>
                    </form>
                </div>
                <hr/>
            </li>';
        }
    }
$abbonamentiTotali = "";
    foreach($templateParams["bigliettievento"] as $biglietto){ 
        if($biglietto["NomeBiglietto"] == "Abbonamento") {
            $abbonamentiTotali .= '
            <li>
                <a class="uk-accordion-title" href="#">' . $biglietto["NomeSezione"] . ' ' .
                    $biglietto["NomeBiglietto"] . ' ' . $biglietto["DataInizioBiglietto"] . '</a>
                    ' . $biglietto["PrezzoBiglietto"] . '€
                <div class="uk-accordion-content">
                    <form class="uk-grid-small" uk-grid>
                        <fieldset class="uk-fieldset uk-width-1-1">
                            <select class="uk-select uk-float-left uk-form-width-small">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            <button class="uk-icon-button uk-float-right uk-form-width-small" uk-icon="cart"></button>
                        </fieldset>
                    </form>
                </div>
                <hr/>
            </li>';
        }
    }
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