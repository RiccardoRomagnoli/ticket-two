<?php
require_once 'inintializer.php';

//Base Template
$templateParams["titolo"] = "TicketTwo";
$templateParams["nome"] = "singoloevento.php";
//Event Template
$idevento = -1;
if(isset($_GET["idevento"])){
    $idevento = $_GET["idevento"];
}
$templateParams["evento"] = $dbh->getEventByIdEvento($idevento);
$templateParams["categorieevento"] = $dbh->getEventCategoriesByIdEvent($idevento);
$templateParams["bigliettievento"] = $dbh->getEventTicketsByIdEvent($idevento);

require 'template/base.php';
?>