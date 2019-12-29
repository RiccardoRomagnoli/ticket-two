<?php
require_once 'initializer.php';

//Base Template
$templateParams["titolo"] = "TicketTwo";
$templateParams["nome"] = "singoloevento.php";
//Event Template
$idevento = -1;
$idutente = 0;
if(isset($_GET["idevento"])){
    $idevento = $_GET["idevento"];
}
if(isset($_SESSION["idUtente"])){
    $idutente = $_SESSION["idUtente"];
}
$templateParams["evento"] = $dbh->getEventByIdEvento($idevento);
$templateParams["eventoseguito"] = $dbh->isEventFollowed($idutente, $idevento);
$templateParams["categorieevento"] = $dbh->getEventCategoriesByIdEvento($idevento);
$templateParams["bigliettievento"] = $dbh->getEventTicketsByIdEvento($idevento);
$templateParams["carrelloaperto"] = $dbh->getCartOpen($idutente);

require 'template/base.php';
?>