<?php 
    if(count($templateParams["evento"])==0) {
        require_once 'template/error404.php';
    } else {
        if(!isUserLoggedIn()) {
            require_once 'template/pagineeventi/singoloeventoguest.php';
        } else {
            switch($_SESSION["tipoUtente"]){
                case "Admin":
                    require_once 'template/pagineeventi/singoloeventoadmin.php';
                    break;
                case "Organizzatore":
                    require_once 'template/pagineeventi/singoloeventoorganizzatore.php';
                    break;
                case "Cliente":
                    require_once 'template/pagineeventi/singoloeventocliente.php';
                    break;
            }
        }
        require_once 'template/pagineeventi/singoloeventobase.php';
    }
?>