<?php
require_once 'initializer.php';
$templateParams["titolo"] = "TicketTwo";
if(isUserLoggedIn() && $_SESSION["tipoUtente"] == "Cliente") {
    $templateParams["nome"] = "template/myTickets.php";
    $templateParams["eventi"] = $dbh->getEventByIdUserThatBuyedTicket($_SESSION['idUtente']);
} else {
    $templateParams["nome"] = "error404.php";
}

require 'template/base.php';
?>