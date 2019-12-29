<?php
require_once 'initializer.php';

$templateParams["js"] = ["js/carrello.js"];

if(isUserLoggedIn()){
    $templateParams["metodidipagamento"] = $dbh->getPaymentCards($_SESSION["idUtente"]);
    $templateParams["biglietti"] = $dbh->getCartByUser($_SESSION["idUtente"]);
    if(!empty($templateParams["biglietti"])){
        $templateParams["idAcquisto"] = $templateParams["biglietti"][0]["IdAcquisto"];
    }
    else{
        $templateParams["idAcquisto"] = -1;
    }
}else{
    if(isset($_COOKIE["IdAcqusito"])){
        $templateParams["biglietti"] = $dbh->getCartByCart($_COOKIE["IdAcqusito"]);
        if(!empty($templateParams["biglietti"])){
            $templateParams["idAcquisto"] = $_COOKIE["IdAcqusito"];
        }
        else{
            $templateParams["idAcquisto"] = -1;
        }
    }else{
        $templateParams["idAcquisto"] = -1;
    }
}

$templateParams["titolo"] = "TicketTwo";
$templateParams["nome"] = "template/carrello.php";

require 'template/base.php';
?>