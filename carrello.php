<?php
require_once 'initializer.php';

if(isSessionActive()){
    //Base Template
    $utente = getUserType();
    $templateParams["js"] = ["js/carrello.js"];
    $templateParams["metodidipagamento"] = $dbh->getPaymentCards($_SESSION["idUtente"]);
    
    if($_SESSION["idUtente"]){
        $templateParams["biglietti"] = $dbh->getTickets($_SESSION["idUtente"]);
    }else{
        $templateParams["biglietti"] = $dbh->getTickets($_COOKIE["IdAcqusito"]);
    }


    $templateParams["titolo"] = "TicketTwo";
    $templateParams["nome"] = "cliente/carrello.php";

    require 'template/base.php';
}
?>