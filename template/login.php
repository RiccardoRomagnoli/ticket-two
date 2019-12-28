<?php if(!isUserLoggedIn()): ?>

<script src="js/login.js"></script>

<!-- Modal Login -->
    <div id="modal-login" class="uk-modal-full uk-modal" uk-modal>
        <div class="uk-modal-dialog uk-flex uk-flex-center uk-flex-middle" uk-height-viewport>
            <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
            <form id="formAnimation">
                <fieldset class="uk-fieldset uk-child-width-expand uk-grid-small">
                    <legend id="loginLegend" class="uk-legend">Login</legend>

                    <div id="nameDiv" class="uk-margin animate-login" hidden>
                        <div class="uk-inline uk-width-1-1">
                            <label hidden for="Nome"></label>
                            <span class="uk-form-icon" uk-icon="icon: user" ></span>
                            <input id="name" class="uk-input" type="text" placeholder="Inserisci Nome"> 
                        </div>
                    </div>

                    <div id="surnameDiv" class="uk-margin animate-login" hidden>
                        <div class="uk-inline uk-width-1-1">
                            <label hidden for="Cognome"></label>
                            <span class="uk-form-icon" uk-icon="icon: user" ></span>
                            <input id="surname" class="uk-input" type="text" placeholder="Inserisci Cognome"> 
                        </div>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-inline uk-width-1-1">
                            <label hidden for="Mail"></label>
                            <span class="uk-form-icon" uk-icon="icon: mail" ></span>
                            <input id="mail" class="uk-input" type="email" placeholder="Inserisci Mail"> 
                        </div>
                    </div>

                    <div class="uk-margin">
                        <div class="uk-inline uk-width-1-1">
                            <label hidden for="Password"></label>
                            <span class="uk-form-icon" uk-icon="icon: lock"></span>
                            <input id="password" class="uk-input" type="password" placeholder="Password">
                        </div>
                    </div>
                    <div id="passwordRipDiv" class="uk-margin animate-login" hidden>
                        <div class="uk-inline uk-width-1-1">
                            <label hidden for="Ripeti Passowrd"></label>
                            <span class="uk-form-icon" uk-icon="icon: lock"></span>
                            <input id="passwordRip" class="uk-input" type="password" placeholder="Ripeti Password">
                        </div>
                    </div>

                    <div id="radio" class="uk-margin animate-login" hidden>
                        <div class="uk-inline uk-width-1-1">
                            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                <label><input class="uk-radio" type="radio" name="radio" value="false" checked> Utente</label>
                                <label><input class="uk-radio" type="radio" name="radio" value="true"> Organizzatore</label>
                            </div>
                        </div>
                    </div>

                    <div class="uk-button-group uk-margin-top uk-width-1-1">
                        <button id="loginBtn" type="button" class="uk-button uk-button-default uk-width-1-2">Login</button>
                        <button id="singupBtn" type="button" class="uk-button uk-button-primary uk-width-1-2">Registrati</button>
                    </div>
                </fieldset >
            </form>
        </div>
    </div>

<?php endif; ?>