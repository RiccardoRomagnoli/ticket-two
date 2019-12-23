<?php
require_once 'initializer.php';

//Base Template
$templateParams["titolo"] = "TicketTwo";
$templateParams["nome"] = "singoloevento.php";
//Event Template
$idevento = -1;
if(isset($_GET["idevento"])){
    $idevento = $_GET["idevento"];
}
$templateParams["evento"] = $dbh->getEventByIdEvento($idevento);
$templateParams["categorieevento"] = $dbh->getEventCategoriesByIdEvento($idevento);
$templateParams["bigliettievento"] = $dbh->getEventTicketsByIdEvento($idevento);

require 'template/base.php';
?>