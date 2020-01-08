<?php 
$sessionData .= '
    <div id="modal-addLuogo" class="uk-modal-full uk-modal" stack="true" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <form id="addLuogoForm" class ="uk-width-1-1 uk-width-1-3@m uk-margin-left uk-margin-right">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend uk-text-center uk-margin-top">Aggiungi Luogo</legend>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Nome luogo *
                        <input required id="addNomeLuogo" class="uk-input" type="text" placeholder="Inserisci nome luogo"></label>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Descrizione luogo
                        <textarea id ="addDescrizioneLuogo" class="uk-textarea" rows="8" placeholder="Inserisci descrizione luogo" required></textarea></label>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Regione del luogo</br>
                        <select style="width: 50%" class="selectRegione" id="addSelectIdRegione">
                        </select></label>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Provincia del luogo</br>
                        <select style="width: 50%" class="selectProvincia" id="addSelectIdProvincia">
                        </select></label>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Città del luogo</br>
                        <select style="width: 50%" class="selectCitta" id="addSelectIdCitta">
                        </select></label>
                    </div>

                    <div class="uk-width-1-1">
                        <button id="addLuogoBtn" type="submit" class="uk-button uk-button-primary uk-margin-left uk-width-1-3 uk-float-left">Salva</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>';
?>