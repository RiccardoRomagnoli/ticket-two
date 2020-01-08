<?php 
$sessionData .= '
    <div id="modal-addReportEvento" class="uk-modal-full uk-modal" stack="true" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <form id="addReportEventoForm" class ="uk-width-1-1 uk-width-1-3@m uk-margin-left uk-margin-right">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend uk-text-center uk-margin-top">Fai un report a quest\' evento</legend>
 
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Descrizione</label>
                        <textarea id ="addDescrizioneReport" class="uk-textarea" rows="8" placeholder="Inserisci descrizione report" required></textarea>
                    </div>

                    <div class="uk-width-1-1">
                        <button id="addReportBtn" type="submit" class="uk-button uk-button-primary uk-margin-left uk-width-1-3 uk-float-left">Segnala</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>';
?>