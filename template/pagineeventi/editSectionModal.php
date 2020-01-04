<?php 
$tipiBiglietto = $dbh->getTipoBiglietti();
$optionTipoBiglietto = '';
foreach ($tipiBiglietto as $tipoBiglietto) {
        $optionTipoBiglietto .= '
        <option value="'. $tipoBiglietto["IdTipoBiglietto"] .'">'. $tipoBiglietto["Nome"] .'</option>
    ';
}
$sessionData .= '
    <div id="modal-editSection" class="uk-modal-full uk-modal" stack="true" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <form id="modificaSezioneForm" class ="uk-width-1-1 uk-width-1-3@m uk-margin-left uk-margin-right">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend uk-text-center uk-margin-top">Modifica Sezione</legend>
                    <input type="hidden" id="idSezioneModifica">
 
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Nome Sezione</label>
                        <input required id="nomeSezione" class="uk-input" type="text" placeholder="Inserisci nome sezione"></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Posti Totali</label>
                        <input required class="uk-input" id="postiTotali" type="number" max="300" step="1">
                    </div>

                    <div class="uk-width-1-1">
                        <button id="saveSezioneBtn" type="submit" class="uk-button uk-button-primary uk-margin-left uk-width-1-3 uk-float-left">Salva</button>
                        <button id="deleteSezioneBtn" type="button" class="uk-button uk-button-danger uk-margin-right uk-width-1-3 uk-float-right">Elimina</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>';
?>