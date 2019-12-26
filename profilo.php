<?php
require_once 'initializer.php';

if(isSessionActive()){
    //Base Template
    $utente = getUserType();
    $templateParams["js"] = ["js/profilo.js"];
    $templateParams["metodidipagamento"] = $dbh->getPaymentCards($_SESSION["idUtente"]);
    $templateParams["interessi"] = $dbh->getInterests($_SESSION["idUtente"]);
    $templateParams["tutti-interessi"] = array_diff(array_column($dbh->getAllInterests(), "NomeCategoria", "IdCategoria"), 
                                                    array_column($templateParams["interessi"], "NomeCategoria", "IdCategoria"));
    $templateParams["titolo"] = "TicketTwo";
    $templateParams["nome"] = strtolower($utente)."/profilo.php";

    require 'template/base.php';
}
?>