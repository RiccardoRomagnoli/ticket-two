<script src="js/editArtist.js"></script>
<?php
    $name = trim($templateParams["infoArtista"][0]["Nome"]);
    $description = trim($templateParams["infoArtista"][0]["Descrizione"]);
    $photo = trim($templateParams["infoArtista"][0]["Foto"]);
    if($photo == ''){
        $photo = 'artist_default.jpg';
    }
?>

<input type="hidden" name="idArtist" id="idArtist" value="<?php echo $_GET["id"];?>" />
<input type="hidden" name="idUser" id="idUser" value="<?php echo $_SESSION['idUtente'];?>" />
<input type="hidden" name="savedFoto" id="savedFoto" value="<?php echo trim($templateParams["infoArtista"][0]["Foto"]);?>" />

<div id="modal-edit" class="uk-modal-full uk-modal" uk-modal>
    <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
        <form class ="uk-width-1-1 uk-width-1-3@m uk-margin-left uk-margin-right">
            <fieldset class="uk-fieldset">

                <legend class="uk-legend uk-text-center uk-margin-top">Modifica Artista</legend>

                <div class="uk-margin">
                    <label class="uk-form-label" for="name">Nome artista *</label>
                    <input id="name" class="uk-input" type="text" placeholder="Inserisci nome artista" value="<?php echo $name?>">
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="description">Descrizione artista</label>
                    <textarea id ="description" class="uk-textarea" rows="8" placeholder="Inserisci descrizione artista" ><?php echo $description?></textarea>
                </div>
                
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Foto artista</label>
                    <img src="upload/<?php echo $photo?>" id="editFoto" alt="">
                </div>

                <label for="fileToUpload">Upload foto</label>
                <input type="file" name="fileToUpload" id="fileToUpload" accept="image/png, image/jpeg, image/jpg">

                <?php 
                    if(strtolower(getUserType()) == 'organizzatore'){
                        echo '<button id="saveBtn" type="button" class="uk-button uk-button-primary uk-align-center">Salva</button>';
                    } else {
                        echo '
                        <div class="uk-button-group uk-margin-top uk-margin-bottom uk-width-1-1">
                            <button id="saveBtn" type="button" class="uk-button uk-button-primary uk-margin-left uk-margin-right uk-width-1-2">Salva</button>
                            <button id="deleteBtn" type="button" class="uk-button uk-button-danger uk-margin-left uk-margin-right uk-width-1-2">Elimina</button>
                        </div>
                        ';
                    }
                ?>

            </fieldset>
        </form>
    </div>
</div>