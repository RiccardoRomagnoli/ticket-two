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
$templateParams["titolo"] = "TicketTwo";
$templateParams["nome"] = "home.php";


require 'template/base.php';
?>