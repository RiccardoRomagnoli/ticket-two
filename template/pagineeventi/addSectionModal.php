<?php 
$sessionData .= '
    <div id="modal-addSection" class="uk-modal-full uk-modal" stack="true" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <form id="addSezioneForm" class ="uk-width-1-1 uk-width-1-3@m uk-margin-left uk-margin-right">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend uk-text-center uk-margin-top">Aggiungi Sezione</legend>
 
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Nome Sezione</label>
                        <input required id="addNomeSezione" class="uk-input" type="text" placeholder="Inserisci nome sezione"></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Posti Totali</label>
                        <input required class="uk-input" id="addPostiTotali" type="number" min="1" max="300" step="1">
                    </div>

                    <div class="uk-width-1-1">
                        <button id="addSezioneBtn" type="submit" class="uk-button uk-button-primary uk-margin-left uk-width-1-3 uk-float-left">Salva</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>';
?>