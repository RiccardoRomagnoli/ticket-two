
<div uk-grid class="uk-grid-stack uk-flex-center uk-flex-middle uk-margin-small-left">

<?php if($templateParams["idAcquisto"] == -1): ?>
<div class="uk-container uk-width-2-3@s uk-width-1-1">
    <span class="uk-card-title uk-text-center uk-text-left@m">
        Il tuo Carrello è vuoto, Utilizza la barra di ricerca e aggiungi subito un biglietto!
    </span>
</div>
<?php else: ?>
<div class="uk-container uk-width-2-3@s uk-width-1-1">
    <span class="uk-card-title uk-text-center uk-text-left@m">
        Ecco i tuoi Biglietti, Procedi con l'aggiunta dei nominativi per ognuno di essi...
    </span>
</div>

<div class="uk-container">
    <div class="uk-child-width-1-3@m uk-child-width-1-2@s uk-grid-small uk-grid-match" uk-grid>
    <?php foreach($templateParams["biglietti"] as $biglietto): ?>
        <div>
            <div class="uk-card uk-card-default"> 
                <div class="uk-card-header">
                    <div class="uk-width-expand">
                        <h3 class="uk-card-title">
                            <?php echo 
                                $biglietto["Titolo"]." - ".
                                $biglietto["NomeSezione"]." ".
                                $biglietto["NomeTipo"]." - ".
                                $biglietto["Prezzo"] 
                            ?>
                        </h3>
                    </div>
                </div>
                <div class="uk-card-body">
                    <label hidden for="Nome"></label>
                    <input id="nome<?php echo $biglietto["IdRigaAcquisto"]?>" class="uk-input" type="text" placeholder="Inserisci Nome">
                    <label hidden for="Cognome"></label>
                    <input id="cognome<?php echo $biglietto["IdRigaAcquisto"]?>" class="uk-input" type="text" placeholder="Inserisci Cognome">
                    <label hidden for="Data Nascita"></label>
                    <input id="datanascita<?php echo $biglietto["IdRigaAcquisto"]?>" class="datanascita uk-input" type="text" placeholder="Inserisci Data di Nascita" data-input>
                </div>
                <div class="uk-card-footer">
                    <button class="uk-button uk-button-default save" name="saveBtn" value="<?php echo $biglietto["IdRigaAcquisto"]?>">Salva</button>
                    <button class="uk-button uk-button-danger remove" name="removeBtn" value="<?php echo $biglietto["IdRigaAcquisto"]?>">Elimina</button>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<div class="uk-container uk-margin-bottom">
    <div class="uk-button-group uk-flex-center">
        <button class="uk-button uk-button-primary uk-text-center">Procedi all'acquisto</button>
    </div>
</div>
<?php endif; ?>
</div
