<?php 
$sessionData .= '
    <div id="modal-addArtista" class="uk-modal-full uk-modal" stack="true" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <form id="addArtistaForm" class ="uk-width-1-1 uk-width-1-3@m uk-margin-left uk-margin-right">
                <fieldset class="uk-fieldset">

                    <legend class="uk-legend uk-text-center uk-margin-top">Aggiungi Artista</legend>
 
                    <div class="uk-margin">
                        <label class="uk-form-label" for="addNomeArtista">Nome Artista</label>
                        <input required id="addNomeArtista" class="uk-input" type="text" text="Nome Artista" placeholder="Inserisci nome artista"></input>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="addDescrizioneArtista">Descrizione Artista</label>
                        <textarea id ="addDescrizioneArtista" class="uk-textarea" rows="8" text="Descrizione Artista" placeholder="Inserisci descrizione artista" required></textarea>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="addPathArtista">Immagine dell\'artista</label></br>
                        <input type="file" name="addPathArtista" text="Upload Immagine" id="addPathArtista"></input>
                    </div>

                    <div class="uk-width-1-1">
                        <button id="addArtistaBtn" type="submit" class="uk-button uk-button-primary uk-margin-left uk-width-1-3 uk-float-left">Salva</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>';
?>