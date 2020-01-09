
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
    <div class="uk-child-width-1-2@s uk-grid-small uk-grid-match" uk-grid>
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
                    <label hidden for="nome<?php echo $biglietto["IdRigaAcquisto"]?>">Nome</label>
                    <input id="nome<?php echo $biglietto["IdRigaAcquisto"]?>" 
                           class="uk-input" 
                           type="text" 
                           placeholder="Inserisci Nome" 
                           value="<?php echo $biglietto["NomeReferente"]?>">

                    <label hidden for="cognome<?php echo $biglietto["IdRigaAcquisto"]?>">Cognome</label>
                    <input id="cognome<?php echo $biglietto["IdRigaAcquisto"]?>" 
                           class="uk-input" 
                           type="text" 
                           placeholder="Inserisci Cognome" 
                           value="<?php echo $biglietto["Cognome"]?>">

                    <label hidden for="datanascita<?php echo $biglietto["IdRigaAcquisto"]?>">Data di Nascita</label>
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

<?php if($templateParams["idAcquisto"] != -1): ?>
<!-- Modal Buy -->
<div id="modal-buy" class="uk-modal-full uk-modal" uk-modal="stack:true;">
    <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
        <form>
            <fieldset class="uk-fieldset uk-child-width-expand uk-grid-small uk-margin-left">
                <legend id="loginLegend" class="uk-legend">Concludi il Pagamento</legend>

                <div class="uk-margin uk-flex-middle uk-flex-center uk-child-width-1-1 uk-child-width-1-2@s" uk-grid>
                    <div class="uk-margin">
                        <label class="uk-form-label" for="carta">Seleziona Carta di Pagamento</label>
                        <div class="uk-form-controls">
                            <select class="uk-select" id="carta">
                                <?php foreach($templateParams["metodidipagamento"] as $carta): ?>
                                    <option value=<?php echo $carta["IdMetodoPagamento"]?>><?php echo "************".substr($carta["NumeroCarta"], -4)." - ".$carta["Anno"]."/".$carta["Mese"]?></option>
                                <?php endforeach; ?>
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
                
                <?php if(isset($_COOKIE["idAcquisto"])): ?>
                    <div class="uk-margin uk-flex-center uk-text-center">
                        <div class="uk-inline uk-width-1-1">
                            <label hidden for="email">Email</label>
                            <span class="uk-form-icon" uk-icon="icon: mail"></span>
                            <input id="email" class="uk-input" type="email" placeholder="Inserisci Email">
                        </div>
                    </div>
                <?php endif; ?>

                <div class="uk-margin uk-flex-center uk-text-center">
                    <div class="uk-inline uk-width-1-1">
                        <div class="uk-inline">
                            <label hidden for="codice">Codice CVC</label>
                            <a class="uk-form-icon" href="#" uk-icon="icon: credit-card" title="CVC"></a>
                            <input id="codice" class="uk-input" type="text" placeholder="Inserisci CVC">
                        </div> 
                    </div>
                </div>

                <div class="uk-button-group uk-margin-top uk-width-1-1 uk-flex-center">
                    <button id="paga" 
                            type="button" 
                            class="uk-button uk-button-default uk-width-1-2" 
                            value="<?php echo $templateParams["idAcquisto"]?>">Paga Ora</button>
                </div>
            </fieldset >
        </form>
    </div>
</div>

<!-- modal aggiungi metodo di pagamento -->
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

<!-- modal pagamento completato -->
<div id="pay-success" uk-modal="bg-close:false;">
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Pagamento Completato!</h2>
        </div>
        <div class="uk-modal-body">
            <p>Il tuo biglietto è disponibile nella tua area riservata e inoltre lo riceverai anche per email. Stampalo e mostralo all'ingresso. Ricorta, il biglietto è nominativo!</p>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <a class="uk-button uk-button-default" href="./carrello.php">Ok</a>
        </div>
    </div>
</div>

<!-- modal inserisci password dopo registrazione -->
<div id="pay-success-register" uk-modal="bg-close:false;">
    <div class="uk-modal-dialog">
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Pagamento Completato!</h2>
        </div>
        <div class="uk-modal-body">
            <p>Riceverai il biglietto per email. Stampalo e mostralo all'ingresso. Ricorta, il biglietto è nominativo!<br>Inserisci una password per creare il tuo account, Così potrai accedere ai tuoi biglietti anche dalla tua area riservata!!</p>
            <div class="uk-margin">
                <div class="uk-inline uk-width-1-1">
                    <label hidden for="passwordPay">Password Account</label>
                    <span class="uk-form-icon" uk-icon="icon: lock"></span>
                    <input id="passwordPay" class="uk-input" type="password" placeholder="Password">
                </div>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button id="crea" class="uk-button uk-button-default" type="button">Crea Account</button>
            <a title="Annulla" class="uk-button uk-button-default" href="./carrello.php">Annulla</a>
        </div>
    </div>
</div>
<?php endif; ?>


