<?php 
$tipoBiglietto = '';
foreach ($templateParams["tipologiaBiglietto"] as $tipo) {
        $tipoBiglietto .= '
        <option value="'. $tipo["IdTipoBiglietto"] .'">'. $tipo["Nome"] .'</option>
    ';
}
$sessionData .= '
    <div id="modal-editBiglietto" class="uk-modal-full uk-modal" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <form id="modificaSezioneForm" class ="uk-width-1-1 uk-width-1-3@m uk-margin-left uk-margin-right">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend uk-text-center uk-margin-top">Modifica Biglietto</legend>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Nome Sezione</label>
                        <input required id="nomeSezione" class="uk-input" type="text" placeholder="Inserisci nome sezione"></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Tipologia Biglietto</label></br>
                        <select id="nomeTipoBiglietto">
                            '. $tipoBiglietto .'
                        </select>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Data inizio evento</label>
                        <input required id="dataInizioBiglietto" class="dataPicker uk-input" type="text" 
                            placeholder="Inserisci Data di inizio evento" data-input></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Data fine evento</label>
                        <input required id="dataFineBiglietto" class="dataPicker uk-input" type="text" 
                            placeholder="Inserisci Data di fine evento" data-input></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Orario</label>
                        <input required id="orarioBiglietto" class="dataPicker uk-input" type="text" 
                            placeholder="Inserisci ora evento" data-input></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Posti Totali</label>
                        <input required class="uk-input" id="postiTotali" type="number" max="300" step="1">
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">Prezzo</label>
                        <input required class="uk-input" id="prezzoBiglietto" type="number" min="0.01" step="0.01">
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