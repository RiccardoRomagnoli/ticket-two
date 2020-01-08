<?php 

$sessionData .= '
    <div id="modal-editBiglietto" class="uk-modal-full uk-modal" stack="true" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <form id="editBigliettoForm" class ="uk-width-1-1 uk-width-1-3@m uk-margin-left uk-margin-right">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend uk-text-center uk-margin-top">Modifica Biglietto</legend>
                    <input type="hidden" id="editIdBiglietto"/>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Sezione del Biglietto</br>
                        <select style="width: 50%" class="selectSezioneEvento" id="editSelectIdSezioneEvento">
                        </select></label>
                        <a href="#modal-addSection" uk-toggle class="uk-toggle uk-float-right">
                            <button id="addSection" class="openModalAddSection uk-icon-button uk-float-right" uk-icon="plus-circle"></button>
                        </a>
                        <a href="#modal-editSection" uk-toggle class="uk-toggle uk-float-right">
                            <button id="openModalEditSectionInEditBiglietto" class="uk-icon-button uk-float-right" uk-icon="pencil"></button>
                        </a>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Tipologia Biglietto</br>
                        <select style="width: 50%" class="selectTipoBiglietto" id="editSelectIdTipoBiglietto">
                        </select></label>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Data inizio evento
                        <input required id="editDataInizioBiglietto" class="dataInizio uk-input" type="text" 
                            placeholder="Inserisci Data di inizio evento" data-input></input></label>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Data fine evento
                        <input required id="editDataFineBiglietto" class="dataFine uk-input" type="text" 
                            placeholder="Inserisci Data di fine evento" data-input></input></label>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Orario
                        <input required id="editOrarioBiglietto" class="dataPicker uk-input" type="text" 
                            placeholder="Inserisci ora evento" data-input></input></label>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Prezzo
                        <input required class="uk-input" id="editPrezzoBiglietto" type="number" min="0.01" step="0.01"></label>
                    </div>

                    <div class="uk-width-1-1">
                        <button id="saveBigliettoBtn" type="submit" class="uk-button uk-button-primary uk-margin-left uk-width-1-3 uk-float-left">Salva</button>
                        <button id="deleteBigliettoBtn" type="button" class="uk-button uk-button-danger uk-margin-right uk-width-1-3 uk-float-right">Elimina</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>';
?>