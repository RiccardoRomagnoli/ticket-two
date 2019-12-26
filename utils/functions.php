<?php
function isActive($pagename){
    if(basename($_SERVER['PHP_SELF'])==$pagename){
        echo " class='active' ";
    }
}

function isUserLoggedIn(){
    return !empty($_SESSION['idUtente']);
}

function getUserType(){
    return $_SESSION["tipoUtente"];
}

function getUserName(){
    return $_SESSION["nome"].' '.$_SESSION["cognome"];
}

function getName(){
    return $_SESSION["nome"];
}

function getSurname(){
    return $_SESSION["cognome"];
}

function registerLoggedUser($user){
    $_SESSION["idUtente"] = $user["IdUtente"];
    $_SESSION["mail"] = $user["Mail"];
    $_SESSION["tipoUtente"] = $user["TipoUtente"];
    $_SESSION["nome"] = $user["Nome"];
    $_SESSION["cognome"] = $user["Cognome"];
}

function updateSession($Nome, $Cognome, $Email){
    $_SESSION["mail"] = $Email;
    $_SESSION["nome"] = $Nome;
    $_SESSION["Cognome"] = $Cognome;
}

function logout(){
    session_unset();
}

function getAction($action){
    $result = "";
    switch($action){
        case 1:
            $result = "Inserisci";
            break;
        case 2:
            $result = "Modifica";
            break;
        case 3:
            $result = "Cancella";
            break;
    }

    return $result;
}


function uploadImage($path, $image){
    $imageName = basename($image["name"]);
    $fullPath = $path.$imageName;
    
    $maxKB = 500;
    $acceptedExtensions = array("jpg", "jpeg", "png", "gif");
    $result = 0;
    $msg = "";
    //Controllo se immagine è veramente un'immagine
    $imageSize = getimagesize($image["tmp_name"]);
    if($imageSize === false) {
        $msg .= "File caricato non è un'immagine! ";
    }
    //Controllo dimensione dell'immagine < 500KB
    if ($image["size"] > $maxKB * 1024) {
        $msg .= "File caricato pesa troppo! Dimensione massima è $maxKB KB. ";
    }

    //Controllo estensione del file
    $imageFileType = strtolower(pathinfo($fullPath,PATHINFO_EXTENSION));
    if(!in_array($imageFileType, $acceptedExtensions)){
        $msg .= "Accettate solo le seguenti estensioni: ".implode(",", $acceptedExtensions);
    }

    //Controllo se esiste file con stesso nome ed eventualmente lo rinomino
    if (file_exists($fullPath)) {
        $i = 1;
        do{
            $i++;
            $imageName = pathinfo(basename($image["name"]), PATHINFO_FILENAME)."_$i.".$imageFileType;
        }
        while(file_exists($path.$imageName));
        $fullPath = $path.$imageName;
    }

    //Se non ci sono errori, sposto il file dalla posizione temporanea alla cartella di destinazione
    if(strlen($msg)==0){
        if(!move_uploaded_file($image["tmp_name"], $fullPath)){
            $msg.= "Errore nel caricamento dell'immagine.";
        }
        else{
            $result = 1;
            $msg = $imageName;
        }
    }
    return array($result, $msg);
}

function isSessionActive(){
    if(!isUserLoggedIn()){
        echo '    
        <link rel="stylesheet" type="text/css" href="css/uikit.min.css" />
        <script src="js/uikit.min.js"></script>
        <script src="js/uikit-icons.min.js"></script>
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/utils.js"></script>';
    
        echo '<script type="text/JavaScript">
        $(document).ready(function(){         
            UIkit.notification({
                message: "Sessione Scaduta",
                status: "warning",
                pos: "top-right",
                timeout: 2500
            });
        });
        </script>';
    
        header("refresh:2; url=index.php");
        return false;
    }else{
        return true;
    }
}

?>