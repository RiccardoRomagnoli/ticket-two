<?php
require_once 'initializer.php';

//Base Template
$templateParams["titolo"] = "TicketTwo";
$templateParams["nome"] = "";
$templateParams["js"] = ["js/evento.js"];
//Event Template
$idutente = 0;
if(isset($_SESSION["idUtente"])){
    $idutente = $_SESSION["idUtente"];
}

if(!isUserLoggedIn()) {
    header("location: error404.php");
} else {
    switch($_SESSION["tipoUtente"]){
        case "Admin" || "Organizzatore":
            $templateParams["nome"] = "aggiungisingoloevento.php";
            break;
        case "Cliente":
            header("location: error404.php");
            break;
    }
}

require 'template/base.php';
?>