<?php
require_once 'initializer.php';
$templateParams["titolo"] = "TicketTwo";
$templateParams["biglietti"] = $dbh->getPurchasedTicketsByIdUserAndIdEvent($_SESSION['idUtente'], $_GET["idEvent"]);
$templateParams["evento"] = $dbh->getEventByIdEvento($_GET["idEvent"]);
if(isUserLoggedIn() && $_SESSION["tipoUtente"] == "Cliente" && count($templateParams["evento"]) == 1 && count($templateParams["biglietti"]) > 0) {
    $templateParams["nome"] = "template/myTicketPurchase.php";
    
} else {
    header("location: error404.php");
}

require 'template/base.php';
?>