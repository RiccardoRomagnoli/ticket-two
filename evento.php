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
} else {
    unset($_SESSION["carrelloaperto"]);
}
$templateParams["evento"] = $dbh->getEventByIdEvento($idevento);
$templateParams["eventoseguito"] = $dbh->isEventFollowed($idutente, $idevento);
$templateParams["categorieevento"] = $dbh->getEventCategoriesByIdEvento($idevento);
$templateParams["bigliettievento"] = $dbh->getEventTicketsByIdEvento($idevento);

if(isset($_COOKIE["idAcquisto"])){
    $_SESSION["carrelloaperto"] = $_COOKIE["idAcquisto"];
}

if($idutente != 0) {
    $_SESSION["carrelloaperto"] = $dbh->getCartOpen($idutente)[0]["IdAcquisto"];
}

require 'template/base.php';
?>