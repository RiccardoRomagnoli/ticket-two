<?php
require_once 'initializer.php';

if(isSessionActive()){
    //Base Template
    $utente = getUserType();
    $templateParams["js"] = ["js/profilo.js"];
    $templateParams["metodidipagamento"] = $dbh->getPaymentCards($_SESSION["idUtente"]);
    $templateParams["interessi"] = $dbh->getInterests($_SESSION["idUtente"]);
    $templateParams["titolo"] = "TicketTwo";
    $templateParams["nome"] = strtolower($utente)."/profilo.php";

    require 'template/base.php';
}
?>