<?php 
$sessionData .= '
    <div id="modal-editEvent" class="uk-modal-full uk-modal" uk-modal stack="true">
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <form id="editEventoForm" class ="uk-width-1-1 uk-width-1-3@m uk-margin-left uk-margin-right">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend uk-text-center uk-margin-top">Modifica Evento</legend>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="editNomeEvento">Nome Evento</label>
                        <input required id="editNomeEvento" class="uk-input" text="Nome Evento" type="text" placeholder="Inserisci nome Evento"></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="editSelectIdArtista">Artisti dell\' evento</label></br>
                        <select style="width: 50%" id="editSelectIdArtista" text="Artisti" class="selectArtista" multiple>
                        </select>
                        <a href="#modal-addArtista" uk-toggle class="uk-toggle uk-float-right">
                            <button class="openModalAddArtista uk-icon-button uk-float-right uk-form-width-small" uk-icon="plus-circle"></button>
                        </a>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="editSelectIdCategoria">Categorie dell\' evento</label></br>
                        <select style="width: 60%" id="editSelectIdCategoria" text="Categorie Evento" class="selectCategoria" multiple>
                        </select>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="editPathLocandina">Locandina evento</label></br>
                        <input type="file" name="pathLocandina" id="editPathLocandina"></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="editSelectIdLuogo">Luogo evento</label></br>
                        <select style="width: 50%" id="editSelectIdLuogo" class="selectLuogo">
                        </select>
                        <a href="#modal-addLuogo" uk-toggle class="uk-toggle uk-float-right">
                            <button class="openModalAddLuogo uk-icon-button uk-float-right uk-form-width-small" uk-icon="plus-circle"></button>
                        </a>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="editDataInizio">Data inizio evento</label>
                        <input required id="editDataInizio" class="dataInizio uk-input" type="text" 
                            placeholder="Inserisci Data di inizio evento" data-input></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="editDataFine">Data fine evento</label>
                        <input required id="editDataFine" class="dataFine uk-input" type="text" 
                            placeholder="Inserisci Data di fine evento" data-input></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="editDescrizioneEvento">Descrizione</label>
                        <textarea required id ="editDescrizioneEvento" class="uk-textarea" rows="8" placeholder="Inserisci descrizione evento"></textarea>
                    </div>
                    <div class="uk-width-1-1">
                        <button id="saveEventoBtn" type="submit" class="uk-button uk-button-primary uk-margin-left uk-width-1-3 uk-float-left">Salva</button>
                        <button id="deleteEventoBtn" type="button" class="uk-button uk-button-danger uk-margin-right uk-width-1-3 uk-float-right">Elimina</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>';
?>