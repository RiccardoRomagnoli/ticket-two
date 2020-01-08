<?php 
$sessionData .= '
    <div id="modal-editEvent" class="uk-modal-full uk-modal" uk-modal stack="true">
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <form id="editEventoForm" class ="uk-width-1-1 uk-width-1-3@m uk-margin-left uk-margin-right">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend uk-text-center uk-margin-top">Modifica Evento</legend>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Nome Evento
                        <input required id="editNomeEvento" class="uk-input" type="text" placeholder="Inserisci nome Evento"></input></label>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Artisti dell\' evento</br>
                        <select style="width: 50%" id="editSelectIdArtista" class="selectArtista" multiple>
                        </select></label>
                        <a href="#modal-addArtista" uk-toggle class="uk-toggle uk-float-right">
                            <button class="openModalAddArtista uk-icon-button uk-float-right uk-form-width-small" uk-icon="plus-circle"></button>
                        </a>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Categorie dell\' evento</br>
                        <select style="width: 60%" id="editSelectIdCategoria" class="selectCategoria" multiple>
                        </select></label>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Locandina evento</br>
                        <input type="file" name="pathLocandina" id="editPathLocandina"></input></label>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Luogo evento</br>
                        <select style="width: 50%" id="editSelectIdLuogo" class="selectLuogo"></label>
                        </select>
                        <a href="#modal-addLuogo" uk-toggle class="uk-toggle uk-float-right">
                            <button class="openModalAddLuogo uk-icon-button uk-float-right uk-form-width-small" uk-icon="plus-circle"></button>
                        </a>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Data inizio evento
                        <input required id="editDataInizio" class="dataInizio uk-input" type="text" 
                            placeholder="Inserisci Data di inizio evento" data-input></input></label>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Data fine evento
                        <input required id="editDataFine" class="dataFine uk-input" type="text" 
                            placeholder="Inserisci Data di fine evento" data-input></input></label>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Descrizione
                        <textarea required id ="editDescrizioneEvento" class="uk-textarea" rows="8" placeholder="Inserisci descrizione evento"></textarea></label>
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