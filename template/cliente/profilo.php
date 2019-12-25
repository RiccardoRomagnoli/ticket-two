<div  class="uk-container" >
    <div class="uk-flex uk-flex-center uk-flex-middle">
        <div uk-grid class="uk-grid-stack uk-flex-center">
            <div class="uk-width-2-3@s uk-width-1-1">
                <h1 class="uk-h1">Ciao <?php echo getUserName(); ?>,</h1>
                <span class="uk-text-lead uk-text-center uk-text-left@m">
                    Qui puoi revisionare i tuoi dati, modificarli, gestire le tue carte di pagamento e molto altro.
                </span>
            </div>
            <hr class="uk-width-1-1 uk-divider-icon">
            <div class="uk-width-2-3@s uk-width-1-1">
                <h1 class="uk-h2">I tuoi dati personali</h1>
                <table class="uk-table uk-table-justify uk-table-middle">
                    <tr>
                        <td class="uk-width-small"><label class="uk-width-1-2 uk-form-label">Nome:</label></td>
                        <td class="uk-width-small"><span class="uk-width-1-2 uk-text-lead"><?php echo getName(); ?></span></td>
                        <td class="uk-width-expand"></td>
                    </tr>
                    <tr>
                        <td class="uk-width-small"><label class="uk-form-label">Cognome:</label></td>
                        <td class="uk-width-small"><span class="uk-text-lead"><?php echo getSurname(); ?></span></td>
                        <td class="uk-width-expand"></td>
                    </tr>
                    <tr>
                        <td class="uk-width-small"><label class="uk-form-label">Email:</label></td>
                        <td class="uk-width-small"><span class="uk-text-lead"><?php echo $_SESSION["mail"]; ?></span></td>
                        <td class="uk-width-expand"></td>
                    </tr>
                    <tr>
                        <td class="uk-width-small"><label class="uk-form-label">Password:</label></td>
                        <td class="uk-width-small"><span class="uk-text-lead"><?php echo "********"; ?></span></td>
                        <td class="uk-width-expand"></td>
                    </tr>
                </table>
                <div class="uk-button-group uk-width-1-1 uk-flex-center uk-margin-top">
                    <button type="button" class="uk-button uk-button-primary uk-width-1-2">Modifica</button>
                    <button hidden type="button" class="uk-button uk-button-danger uk-width-1-2">Annulla</button>
                </div>
            </div>
            <div class="uk-width-1-1 uk-text-center"><div class="uk-divider-small"></div></div>
            <div class="uk-width-2-3@s uk-width-1-1">
                <h1 class="uk-h2">I tuoi metodi di pagemento salvati</h1>
                <?php if(count($templateParams["metodidipagamento"])>0): ?>
                    <div class="uk-overflow-auto">
                    <table class="uk-table uk-table-justify uk-table-middle uk-table-divider">
                        <thead>
                            <tr>
                                <th class="uk-width-expand">Titolare</th>
                                <th class="uk-width-small">Numero</th>
                                <th class="uk-width-shrink uk-text-nowrap">Data Scadenza</th>
                                <th></th>
                            </tr>
                        </thead>
                        <?php foreach($templateParams["metodidipagamento"] as $carta): ?>
                            <tr>
                                <td><span class="uk-text-lead"><?php echo $carta["Titolare"]?></span></td>
                                <td><span class="uk-text-lead"><?php echo "************".substr($carta["NumeroCarta"], -4)?></span></td>
                                <td class="uk-text-nowrap"><span class="uk-text-lead"><?php echo $carta["Anno"]."-".$carta["Mese"]?></span></td>
                                <td><button class="remove_card uk-button uk-button-danger" 
                                            name="idCarta" 
                                            value="<?php echo $carta["IdMetodoPagamento"]?>">Rimuovi</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                    </div>
                <?php else:?>
                    <span class="uk-text-lead">Non hai nessun metodo di pagamento salvato, utilizza il pulsante qui sotto per iniziare!</span>
                <?php endif; ?>
                <div class="uk-button-group uk-width-1-1 uk-flex-center">
                    <a class="uk-button uk-button-primary uk-margin-top uk-width-1-2" href="#add-payment" uk-toggle>Aggiungi</a>
                </div>
            </div>
            <div class="uk-width-1-1 uk-text-center"><div class="uk-divider-small"></div></div>
            <div class="uk-width-2-3@s uk-width-1-1">
                <h1 class="uk-h2">I Tuoi Interessi</h1>
                <div class="uk-width-1-1 uk-margin">
                    <?php foreach($templateParams["interessi"] as $interesse): ?>
                        <div class="uk-inline uk-margin-left">
                        <button class="removeInterestBtn" type="button" uk-icon="close" value="<?php echo $interesse["IdCategoria"]?>"></button>
                        <span class="uk-label"><?php echo $interesse["NomeCategoria"]?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php if(count($templateParams["interessi"])==0): ?>
                    <span class="uk-text-lead">Non hai nessun interesse salvato, utilizza il pulsante qui sotto per iniziare!</span>
                <?php endif; ?>
                <div class="uk-button-group uk-width-1-1 uk-flex-center">
                    <button type="button" class="uk-margin-top uk-button uk-button-primary uk-width-1-2">Aggiungi</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="add-payment" uk-modal>
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
            <button id="addPaymentBtn" class="uk-button uk-button-primary" type="button">Invia</button>
        </div>
    </div>
</div>