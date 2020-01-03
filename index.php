<?php 
    class Categoria{
        public $nome;
        public $eventiCategoria;

    public function __construct($nome, $eventiCategoria) {
        $this->nome = $nome;
        $this->eventiCategoria = $eventiCategoria;
        }
    }
?>

<?php
require_once 'initializer.php';
$templateParams["categorie"] = array();
foreach($dbh->getCategories() as $categoriaDB):
    $nomeCategoria = $categoriaDB["Nome"];
    $eventiInCategoria = $dbh->getLatestTenEventsByCategory($categoriaDB["IdCategoria"]);
    array_push($templateParams["categorie"], new Categoria($nomeCategoria, $eventiInCategoria));
endforeach;
if(isUserLoggedIn()) {
    switch($_SESSION["tipoUtente"]){
        case "Admin":
            break;
        case "Organizzatore":
            $templateParams["titoloEventi1"] = 'I miei eventi organizzati più recenti';
            $templateParams["eventi1"] = $dbh->getLatestTenCreatedEventsByIdUserCreator($_SESSION['idUtente']);
            $templateParams["titoloEventi2"] = 'Ultimi eventi inseriti simili ai miei';
            $templateParams["eventi2"] = $dbh->getLatestTenEventsSimilarToMyOrganizedEvents($_SESSION['idUtente']);
            break;
        case "Cliente":
            $templateParams["titoloEventi1"] = 'Secondo i tuoi interessi';
            $eventiPerTe = $dbh->getTenRandomValidInterestEvents($_SESSION['idUtente']);
            if(count($eventiPerTe < 10)){
                $eventiSupplementari = $dbh->getNRandomValidEventsExceptSomeEvents(10 - count($eventiPerTe), $eventiPerTe);
                $eventiPerTe = array_merge($eventiPerTe, $eventiSupplementari);
            }
            $templateParams["eventi1"] = $eventiPerTe;
            $templateParams["titoloEventi2"] = 'Ultimi eventi inseriti';
            $templateParams["eventi2"] = $dbh->getLatestTenEvents();
            break;
    }
} else {
    $templateParams["titoloEventi1"] = 'Eventi casuali';
    $templateParams["eventi1"] = $dbh->getTenValidRandomEvents();
    $templateParams["titoloEventi2"] = 'Ultimi eventi inseriti';
    $templateParams["eventi2"] = $dbh->getLatestTenEvents();
}
$templateParams["titolo"] = "TicketTwo";
$templateParams["nome"] = "home.php";


require 'template/base.php';
?>