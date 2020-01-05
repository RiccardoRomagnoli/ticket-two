<?php
require_once 'initializer.php';
$templateParams["titolo"] = "TicketTwo";
if(isUserLoggedIn()) {
    $templateParams["nome"] = "template/notifications.php";
    $templateParams["notificheDaLeggere"] = $dbh->getUserNotificationsNotReaded($_SESSION['idUtente']);
    $templateParams["notificheLette"] = $dbh->getUserNotificationsAlreadyReaded($_SESSION['idUtente']);
} else {
    $templateParams["nome"] = "error404.php";
}

require 'template/base.php';
?>