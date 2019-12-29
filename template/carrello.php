
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
                                $biglietto["Prezzo"]." €" 
                            ?>
                        </h3>
                    </div>
                </div>
                <div class="uk-card-body">
                    <label hidden for="Nome"></label>
                    <input id="nome<?php echo $biglietto["IdRigaAcquisto"]?>" 
                           class="uk-input" 
                           type="text" 
                           placeholder="Inserisci Nome" 
                           value="<?php echo $biglietto["NomeReferente"]?>">

                    <label hidden for="Cognome"></label>
                    <input id="cognome<?php echo $biglietto["IdRigaAcquisto"]?>" 
                           class="uk-input" 
                           type="text" 
                           placeholder="Inserisci Cognome" 
                           value="<?php echo $biglietto["Cognome"]?>">

                    <label hidden for="Data Nascita"></label>
                    <input  id="datanascita<?php echo $biglietto["IdRigaAcquisto"]?>" 
                            class="datanascita uk-input" 
                            type="text" 
                            placeholder="Inserisci Data di Nascita" 
                            data-input 
                            value="<?php echo $biglietto["DataNascita"]?>">
                </div>
                <div class="uk-card-footer">
                    <div class="uk-button-group uk-flex-center uk-width-1-1 ">
                        <button class="uk-button uk-button-default save" name="saveBtn" value="<?php echo $biglietto["IdRigaAcquisto"]?>">Salva</button>
                        <button class="uk-button uk-button-danger remove" name="removeBtn" value="<?php echo $biglietto["IdRigaAcquisto"]?>">Elimina</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<div class="uk-container uk-margin-bottom uk-width-1-1">
    <div class="uk-button-group uk-flex-center uk-width-1-1">
        <button class="uk-button uk-button-primary uk-text-center" href="#modal-buy" uk-toggle>Procedi all'acquisto</button>
    </div>
</div>
<?php endif; ?>
</div>

<!-- Modal Buy -->
<div id="modal-buy" class="uk-modal-full uk-modal" uk-modal="stack:true;">
    <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
        <form>
            <fieldset class="uk-fieldset uk-child-width-expand uk-grid-small">
                <legend id="loginLegend" class="uk-legend">Concludi il Pagamento</legend>

                <div class="uk-margin uk-flex-middle uk-flex-center uk-child-width-1-1 uk-child-width-1-2@s" uk-grid>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="carta">Seleziona Carta di Pagamento</label>
                        <div class="uk-form-controls">
                            <select class="uk-select" id="carta">
                                <option>Option 01</option>
                                <option>Option 02</option>
                            </select>
                        </div>
                    </div>

                    <div class="uk-margin uk-text-center">
                        <label class="uk-form-label" for="Carta">Oppure </label>
                        <div class="uk-button-group">
                            <a class="uk-button uk-button-small uk-button-primary" href="#add-payment" uk-toggle>Aggiungi</a>
                        </div>
                    </div>
                </div>

                <div class="uk-margin uk-flex-center uk-text-center">
                    <div class="uk-inline uk-width-1-1">
                        <div class="uk-inline">
                            <a class="uk-form-icon" href="#" uk-icon="icon: credit-card"></a>
                            <input id="codice" class="uk-input" type="text" placeholder="Inserisci CVC">
                        </div> 
                    </div>
                </div>

                <div class="uk-button-group uk-margin-top uk-width-1-1 uk-flex-center">
                    <button id="paga" 
                            type="button" 
                            class="uk-button uk-button-default uk-width-1-2" >Paga Ora</button>
                </div>
            </fieldset >
        </form>
    </div>
</div>

<div id="add-payment" uk-modal="stack:true;">
    <div class="uk-modal-dialog" bg-close esc-close>
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Aggiungi Metodo di Pagamento</h2>
        </div>
        <div class="uk-modal-body">
            <form class="uk-form-stacked">
                <div class="uk-margin">
                    <label class="uk-form-label" for="titolare">Titolale</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="titolare" type="text" placeholder="Inserisci Nome e Cognome...">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="numero">Numero Della Carta</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="numero" type="text" placeholder="Inserisci 16 cifre...">
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="data">Anno e Mese</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="data" type="text" placeholder="MM/AAAA">
                    </div>
                </div>
            </form>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Annulla</button>
            <button id="addPaymentBtn" class="uk-button uk-button-primary" type="button">Aggiungi</button>
        </div>
    </div>
</div>


