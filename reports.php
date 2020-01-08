<?php
require_once 'initializer.php';
$templateParams["titolo"] = "TicketTwo";
if(isUserLoggedIn() && $_SESSION["tipoUtente"] == "Amministratore") {
    //$templateParams["nome"] = "template/reports.php";
    //$templateParams["segnalazioni"] = $dbh->getReports();
} else {
    header("location: error404.php");
}

require 'template/base.php';
?>