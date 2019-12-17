<ul class="uk-nav uk-nav-primary">

<?php
    if(!isUserLoggedIn()){
        echo '
                <div class="uk-flex">
                    <div class="uk-margin-auto uk-margin-medium-bottom">
                        <a uk-icon="icon: user; ratio: 5" ></a>
                    </div>
                </div>
                <li class="uk-nav-header">Menu</li>
                <li class="uk-nav-divider"></li>
                <li><a href="#">Login</a></li>
                <li><a href="#">Carrello</a></li>
            ';
    }else{
        switch($_SESSION["tipoUtente"]){
            case "Admin" :
                echo '
                    <li class="uk-nav-header">Menu</li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="#">Profilo</a></li>
                    <li><a href="#">Segnalazioni</a></li>
                    <li><a href="#">Approvazioni</a></li>
                    <li><a href="#">Notifiche</a></li>
                ';
                break;
            case "Organizzatore" :
                echo '
                    <li class="uk-nav-header">Menu</li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="#">Profilo</a></li>
                    <li><a href="#">Crea Evento</a></li>
                    <li><a href="#">I Miei Eventi</a></li>
                    <li><a href="#">Notifiche</a></li>
                ';
                break;            
            case "Cliente" :
                echo '
                    <li class="uk-nav-header">Menu</li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="#">Profilo</a></li>
                    <li><a href="#">I Miei Biglietti</a></li>
                    <li><a href="#">I Miei Eventi Seguiti</a></li>
                    <li><a href="#">Carrello</a></li>
                    <li><a href="#">Notifiche</a></li>
                ';
                break;
        }
    }
?>

</ul>

