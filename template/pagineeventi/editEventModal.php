<?php 
$optionsLuoghi = '<option value="'. $evento["IdLuogo"] .'">'. $evento["NomeLuogo"] .'</option>';
$luoghi = $dbh->getLuoghi();
foreach ($luoghi as $luogo) {
    if($luogo["IdLuogo"] != $evento["IdLuogo"]){
        $optionsLuoghi .= '
        <option value="'. $luogo["IdLuogo"] .'">'. $luogo["Nome"] .'</option>
    ';
    }
}
$sessionData .= '
    <div id="modal-editEvent" class="uk-modal-full uk-modal" uk-modal stack="true">
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <form id="modificaEventoForm" class ="uk-width-1-1 uk-width-1-3@m uk-margin-left uk-margin-right">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend uk-text-center uk-margin-top">Modifica Evento</legend>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Nome Evento</label>
                        <input required id="nomeEvento" class="uk-input" type="text" placeholder="Inserisci nome Evento" value="'. $evento["TitoloEvento"] .'"></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Locandina evento</label>
                        <input type="file" name="pathLocandina" id="pathLocandina" />
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Luogo evento</label></br>
                        <select style="width: 50%" id="idLuogo">
                            '. $optionsLuoghi .'
                        </select>
                        <a href="#modal-addLuogo" uk-toggle class="uk-toggle uk-float-right">
                            <button id="apriModalAddLuogo" class="uk-icon-button uk-float-right uk-form-width-small" uk-icon="plus-circle"></button>
                        </a>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Data inizio evento</label>
                        <input required id="dataInizioModifica" class="dataPicker uk-input" type="text" 
                            placeholder="Inserisci Data di inizio evento" data-input value="'. $evento["DataInizio"] .'"></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Data fine evento</label>
                        <input required id="dataFineModifica" class="dataPicker uk-input" type="text" 
                            placeholder="Inserisci Data di fine evento" data-input value="'. $evento["DataFine"] .'"></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Descrizione</label>
                        <textarea required id ="descrizioneEvento" class="uk-textarea" rows="8" placeholder="Inserisci descrizione evento">'. $evento["EventoDescrizione"] .'</textarea>
                    </div>
                    <div class="uk-width-1-1">
                        <button id="saveEventBtn" type="submit" class="uk-button uk-button-primary uk-margin-left uk-width-1-3 uk-float-left">Salva</button>
                        <button id="deleteEventBtn" type="button" class="uk-button uk-button-danger uk-margin-right uk-width-1-3 uk-float-right">Elimina</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>';
?>