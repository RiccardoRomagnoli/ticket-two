<?php 
    if(count($templateParams["evento"])==0) {
        require 'error404.php';
    } else {
        if(!isUserLoggedIn()) {
            require 'template/pagineeventi/singoloeventoguest.php';
        } else {
            switch($_SESSION["tipoUtente"]){
                case "Admin":
                    require 'template/pagineeventi/singoloeventoadmin.php';
                    break;
                case "Organizzatore":
                    require 'template/pagineeventi/singoloeventoorganizzatore.php';
                    break;
                case "Cliente":
                    require 'template/pagineeventi/singoloeventocliente.php';
                    break;
            }
            require 'template/pagineeventi/singoloeventobase.php';
        }
    }
?>