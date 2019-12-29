<script src="js/followArtist.js"></script>
<input type="hidden" name="idArtist" id="idArtist" value="<?php echo $_GET["id"];?>" />
<input type="hidden" name="idUser" id="idUser" value="<?php echo $_SESSION['idUtente'];?>" />
<?php
    if(!($dbh->checkIfUserFollowArtist($_SESSION['idUtente'], $_GET["id"]))){
        echo '<button id="followBtn" class="uk-button uk-button-default uk-button-primary uk-margin-top">Segui</button>';
    } else {
        echo '<button id="followBtn" class="uk-button uk-button-default uk-button-primary uk-margin-top">Segui già</button>';
    }
?>