<?php
require_once 'initializer.php';

//Base Template
$templateParams["titolo"] = "TicketTwo";
$templateParams["nome"] = "artist_template.php";
$templateParams["infoArtista"] = $dbh->getArtistById(3);
$templateParams["eventi"] = $dbh->getEventByIdArtist(3);

require 'template/base.php';
?>