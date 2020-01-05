<?php 
$regioni = $dbh->getRegione();

$optionRegione = '<option></option>';
$firstOptionValue = $regioni[0]["IdRegione"];
foreach ($regioni as $r) {
        $optionRegione .= '
        <option value="'. $r["IdRegione"] .'">'. $r["Nome"] .'</option>
    ';
}

$sessionData .= '
    <div id="modal-addLuogo" class="uk-modal-full uk-modal" stack="true" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <form id="addLuogoForm" class ="uk-width-1-1 uk-width-1-3@m uk-margin-left uk-margin-right">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend uk-text-center uk-margin-top">Aggiungi Luogo</legend>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Nome luogo *</label>
                        <input required id="nomeAddLuogo" class="uk-input" type="text" placeholder="Inserisci nome luogo">
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Descrizione luogo</label>
                        <textarea id ="descrizioneAddLuogo" class="uk-textarea" rows="8" placeholder="Inserisci descrizione luogo" required></textarea>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Regione del luogo</label></br>
                        <select style="width: 50%" id="idAddRegione">
                            '. $optionRegione .'
                        </select>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Provincia del luogo</label></br>
                        <select style="width: 50%" id="idAddProvincia">
                        </select>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Città del luogo</label></br>
                        <select style="width: 50%" id="idAddCitta">
                        </select>
                    </div>

                    <div class="uk-width-1-1">
                        <button id="saveAddLuogoBtn" type="submit" class="uk-button uk-button-primary uk-margin-left uk-width-1-3 uk-float-left">Salva</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>';
?>