<?php
require_once 'initializer.php';
if(isUserLoggedIn()) {
    switch($_SESSION["tipoUtente"]){
        case "Admin":
            $templateParams["bottone"] = 'template/admin/artist.php';
            break;
        case "Organizzatore":
            $templateParams["bottone"] = 'template/organizzatore/artist.php';
            break;
        case "Cliente":
            $templateParams["bottone"] = 'template/cliente/artist.php';
            break;
    }
}
//Base Template
$templateParams["titolo"] = "TicketTwo";
$templateParams["infoArtista"] = $dbh->getArtistById($_GET["id"]);
if(count($templateParams["infoArtista"])==0){
    $templateParams["nome"] = "error404.php";
} else {
    $templateParams["nome"] = "template/artist.php";
    $templateParams["eventi"] = $dbh->getEventByIdArtist($_GET["id"]);
}

require 'template/base.php';
?>