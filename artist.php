<?php
require_once 'initializer.php';
if(!isset($_GET["id"])){
    header("location: ./error404.php");
}
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
$templateParams["nome"] = "template/artist.php";
$templateParams["infoArtista"] = $dbh->getArtistById($_GET["id"]);
if(count($templateParams["infoArtista"])==0){
    header("location: ./error404.php");
}
$templateParams["eventi"] = $dbh->getEventByIdArtist($_GET["id"]);

require 'template/base.php';
?>