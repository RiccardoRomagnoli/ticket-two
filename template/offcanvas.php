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
                <li><a href="#modal-login" uk-toggle class="uk-toggle">Login</a></li>
                <li><a href="./carrello.php">Carrello</a></li>
            ';
    }else{
        switch($_SESSION["tipoUtente"]){
            case "Admin" :
                echo '
                    <li class="uk-nav-header">Menu</li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="./profilo.php">Profilo</a></li>
                    <li><a href="#">Segnalazioni</a></li>
                    <li><a href="#">Approvazioni</a></li>
                    <li><a href="./notifications.php">Notifiche</a></li>
                    <li><a href="./logout.php">Disconnettiti</a></li>
                ';
                break;
            case "Organizzatore" :
                echo '
                    <li class="uk-nav-header">Menu</li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="./profilo.php">Profilo</a></li>
                    <li><a href="./addevento.php">Crea Evento</a></li>
                    <li><a href="./myCreatedEvents.php">I Miei Eventi</a></li>
                    <li><a href="./notifications.php">Notifiche</a></li>
                    <li><a href="./logout.php">Disconnettiti</a></li>
                ';
                break;            
            case "Cliente" :
                echo '
                    <li class="uk-nav-header">Menu</li>
                    <li class="uk-nav-divider"></li>
                    <li><a href="./profilo.php">Profilo</a></li>
                    <li><a href="./myTickets.php">I Miei Biglietti</a></li>
                    <li><a href="./myFollowedEvents.php">I Miei Eventi Seguiti</a></li>
                    <li><a href="./carrello.php">Carrello</a></li>
                    <li><a href="./notifications.php">Notifiche</a></li>
                    <li><a href="./logout.php">Disconnettiti</a></li>
                ';
                break;
        }
    }
?>

</ul>

