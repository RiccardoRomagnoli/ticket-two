<?php 
$sessionData .= '
    <div id="modal-addBiglietto" class="uk-modal-full uk-modal" stack="true" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <form id="addBigliettoForm" class ="uk-width-1-1 uk-width-1-3@m uk-margin-left uk-margin-right">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend uk-text-center uk-margin-top">Aggiungi Biglietto</legend>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Sezione del Biglietto</label></br>
                        <select style="width: 50%" class="selectSezioneEvento" id="addSelectIdSezioneEvento">
                        </select>
                        <a href="#modal-addSection" uk-toggle class="uk-toggle uk-float-right">
                            <button class="openModalAddSection uk-icon-button uk-float-right" uk-icon="plus-circle"></button>
                        </a>
                        <a href="#modal-editSection" uk-toggle class="uk-toggle uk-float-right">
                            <button id="openModalEditSectionInAddBiglietto" class="uk-icon-button uk-float-right" uk-icon="pencil"></button>
                        </a>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Tipologia Biglietto</label></br>
                        <select style="width: 50%" class="selectTipoBiglietto" id="addSelectIdTipoBiglietto">
                        </select>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Data inizio evento</label>
                        <input required id="addDataInizioBiglietto" class="dataInizio uk-input" type="text" 
                            placeholder="Inserisci Data di inizio evento" data-input></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Data fine evento</label>
                        <input required id="addDataFineBiglietto" class="dataFine uk-input" type="text" 
                            placeholder="Inserisci Data di fine evento" data-input></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Orario</label>
                        <input required id="addOrarioBiglietto" class="orarioBiglietto uk-input" type="text" 
                            placeholder="Inserisci ora evento" data-input></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Prezzo</label>
                        <input required class="uk-input" id="addPrezzoBiglietto" type="number" min="0.01" step="0.01">
                    </div>

                    <div class="uk-width-1-1">
                        <button id="addBigliettoBtn" type="submit" class="uk-button uk-button-primary uk-margin-left uk-width-1-3 uk-float-left">Salva</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>';
?>