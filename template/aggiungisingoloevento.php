<?php
    $optionsLuoghi = '<option value=""></option>';
    $luoghi = $dbh->getLuoghi();
    $sessionData = '';
    foreach ($luoghi as $luogo) {
            $optionsLuoghi .= '
            <option value="'. $luogo["IdLuogo"] .'">'. $luogo["Nome"] .'</option>
        ';
    }
    require_once 'template/pagineeventi/addLuogoModal.php';
    require_once 'template/pagineeventi/addArtistaModal.php';
    echo $sessionData;
?>

<div class="uk-section-xsmall uk-padding-remove-top uk-section-default uk-flex uk-flex-center"> 
    <div class="uk-margin-small uk-width-3-4"> 

        <form class="uk-grid-small" id="addEventoForm">
            <fieldset class="uk-fieldset">
                <legend class="uk-legend uk-text-center uk-margin-top">Modifica Evento</legend>
                <div class="uk-width-1-1">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="addNomeEvento">Nome Evento</label>
                        <input required id="addNomeEvento" class="uk-input" type="text" placeholder="Inserisci nome Evento" value=""></input>
                    </div>
                </div>
                <div class="uk-width-1-1">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="addSelectIdArtista">Artisti dell' evento</label></br>
                        <select style="width: 50%" class="selectArtista" id="addSelectIdArtista" multiple>
                        </select>
                        <a href="#modal-addArtista" uk-toggle class="uk-toggle uk-float-right">
                            <button class="openModalAddArtista uk-icon-button uk-float-right uk-form-width-small" uk-icon="plus-circle"></button>
                        </a>
                    </div>
                </div>
                <div class="uk-width-1-1">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="addSelectIdCategoria">Categorie dell' evento</label></br>
                        <select style="width: 60%" class="selectCategoria" id="addSelectIdCategoria" multiple>
                        </select>
                    </div>
                </div>
                <div class="uk-width-1-1">
                <div class="uk-margin">
                        <label class="uk-form-label" for="addPathLocandina">Locandina evento</label></br>
                        <input type="file" name="addPathLocandina" id="addPathLocandina"></input>
                    </div>
                </div>
                <div class="uk-width-1-1">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="addSelectIdLuogo">Luogo evento</label></br>
                        <select style="width: 50%" class="selectLuogo" id="addSelectIdLuogo">
                            <?php echo $optionsLuoghi ?>
                        </select>
                        <a href="#modal-addLuogo" uk-toggle class="uk-toggle uk-float-right">
                            <button class="openModalAddLuogo uk-icon-button uk-float-right uk-form-width-small" uk-icon="plus-circle"></button>
                        </a>
                    </div>
                </div>
                <div class="uk-width-1-1">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="addDataInizio">Data inizio evento</label>
                        <input required id="addDataInizio" class="dataInizio uk-input" type="text" 
                            placeholder="Inserisci Data di inizio evento" data-input value=""></input>
                    </div>
                </div>
                <div class="uk-width-1-1">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="addDataFine">Data fine evento</label>
                        <input required id="addDataFine" class="dataFine uk-input" type="text" 
                            placeholder="Inserisci Data di fine evento" data-input value=""></input>
                    </div>
                </div>
                <div class="uk-width-1-1">
                    <div class="uk-margin">
                        <label class="uk-form-label" for="addDescrizioneEvento">Descrizione</label>
                        <textarea required id ="addDescrizioneEvento" class="uk-textarea" rows="8" placeholder="Inserisci descrizione evento"></textarea>
                    </div>
                </div>
                <div class="uk-width-1-1">
                    <button id="addEventBtn" type="submit" class="uk-button uk-button-primary uk-margin-left uk-width-1-3 uk-float-left">Salva</button>
                    <button id="resetEventBtn" type="reset" class="uk-button uk-button-danger uk-margin-right uk-width-1-3 uk-float-right">Reset</button>
                </div>
            </fieldset>      
        </form>
    </div>
</div>