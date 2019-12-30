<?php
require_once 'initializer.php';
if(isUserLoggedIn()) {
    switch($_SESSION["tipoUtente"]){
        case "Admin":
            $templateParams["bottone"] = 'template/admin/place.php';
            break;
        case "Organizzatore":
            $templateParams["bottone"] = 'template/organizzatore/place.php';
            break;
        case "Cliente":
            $templateParams["bottone"] = 'template/cliente/place.php';
            break;
    }
}
//Base Template
$templateParams["titolo"] = "TicketTwo";
$templateParams["infoLuogo"] = $dbh->getPlaceById($_GET["id"]);
if(count($templateParams["infoLuogo"])==0){
    $templateParams["nome"] = "error404.php";
} else {
    $templateParams["nome"] = "template/place.php";
    $templateParams["eventi"] = $dbh->getEventByIdPlace($_GET["id"]);
}

require 'template/base.php';
?>