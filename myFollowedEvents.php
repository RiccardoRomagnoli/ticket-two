<?php
require_once 'initializer.php';
$templateParams["titolo"] = "TicketTwo";
if(isUserLoggedIn() && $_SESSION["tipoUtente"] == "Cliente") {
    $templateParams["nome"] = "template/myFollowedEvents.php";
    $templateParams["eventi"] = $dbh->getFollowedEventsByIdUser($_SESSION['idUtente']);
} else {
    header("location: error404.php");
}

require 'template/base.php';
?>