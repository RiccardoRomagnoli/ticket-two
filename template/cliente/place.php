<script src="js/followPlace.js"></script>
<input type="hidden" name="idPlace" id="idPlace" value="<?php echo $_GET["id"];?>" />
<input type="hidden" name="idUser" id="idUser" value="<?php echo $_SESSION['idUtente'];?>" />
<?php
    if(!($dbh->checkIfUserFollowPlace($_SESSION['idUtente'], $_GET["id"]))){
        echo '<button id="followBtn" class="uk-button uk-button-default uk-button-primary uk-margin-top">Segui</button>';
    } else {
        echo '<button id="followBtn" class="uk-button uk-button-default uk-button-primary uk-margin-top">Segui già</button>';
    }
?>