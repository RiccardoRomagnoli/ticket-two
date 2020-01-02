<?php
require_once 'initializer.php';
$templateParams["titolo"] = "TicketTwo";
if(isUserLoggedIn() && $_SESSION["tipoUtente"] == "Organizzatore") {
    $templateParams["nome"] = "template/myCreatedEvents.php";
    $templateParams["eventi"] = $dbh->getCreatedEventsByIdUserCreator($_SESSION['idUtente']);
} else {
    $templateParams["nome"] = "error404.php";
}

require 'template/base.php';
?>