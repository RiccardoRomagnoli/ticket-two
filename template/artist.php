<!-- pagina artista base -->

<!-- controlli iniziali -->
<?php
    $nome_artista = $templateParams["infoArtista"][0]["Nome"];
    if($nome_artista == ""){
        $nome_artista = "Nome assente";
    }
    $foto_artista = $templateParams["infoArtista"][0]["Foto"];
    if($foto_artista == "" || !file_exists("upload/" . $foto_artista)){
        $foto_artista = "artist_default.jpg";
    }
    $descrizione_artista = $templateParams["infoArtista"][0]["Descrizione"];
    if($descrizione_artista == ""){
        $descrizione_artista = "Nessuna descrizione disponibile per questo artista";
    }
?>

<!-- nome artista e pulsante -->
<div class="uk-grid uk-text-center uk-margin-bottom uk-grid-collapse uk-width-1-1">
    <div class="uk-panel uk-width-1-1 uk-width-1-2@m">
        <div class="uk-grid uk-text-center uk-grid-collapse uk-width-1-1">
            <div class="uk-panel uk-width-0-0 uk-width-1-6@m">
            </div>
            <div class="uk-panel uk-width-1-1 uk-width-5-6@m">
                <h1 class="uk-heading-small uk-width-1-1 uk-text-left@m"><?php echo $nome_artista; ?></h1>
            </div>
        </div>
    </div>
    <div class="uk-panel uk-width-1-1 uk-width-1-2@m">
        <div class="uk-grid uk-text-center uk-grid-collapse uk-width-1-1">
            <div class="uk-panel uk-width-0-0 uk-width-1-2@m">
            </div>
            <div class="uk-panel uk-width-1-1 uk-width-1-2@m">
                <?php
                if(isset($templateParams["bottone"])){
                    require($templateParams["bottone"]);
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- foto e descrizione artista -->
<div class="uk-grid-column-small uk-grid-row-large uk-child-width-1-1 uk-text-center uk-margin-remove-top" uk-grid>
    <div>
        <div class="uk-container">
            <div class="uk-card uk-card-default">
                <div class="uk-card-media-top">
                    <div class="uk-height-large uk-background-cover uk-light" data-src="upload/<?php echo $foto_artista; ?>" uk-img="" style="background-image: upload/<?php echo $foto_artista; ?>"></div>
                </div>
                <div class="uk-card-body">
                    <ul uk-accordion>
                        <li>
                            <a class="uk-accordion-title" href="#">Espandi</a>
                            <div class="uk-accordion-content">
                                <p><?php echo $descrizione_artista; ?></p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- eventi -->
<div uk-slider class="uk-section  uk-margin-top uk-padding-small">
    <h2 class="uk-text-center uk-width-1-1">Eventi in programma</h2>
    <hr class="uk-divider-icon">
    <?php echo eventSlideShow($templateParams["eventi"])?>
</div>

<?php
function eventSlideShow($eventi){
    if(count($eventi) == 0){
        return '<h2 class="uk-text-center uk-width-1-1">Nessun evento in programma</h2>';
    } else {
        $build = '
            <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1" uk-slider>
                <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-child-width-1-5@xl uk-grid">';
        foreach($eventi as $evento):
            $build = $build . cardEvent($evento);
        endforeach;
        $build = $build . '
                </ul>
                <a class="uk-position-center-left uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
            </div>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
        ';
        return $build;
    }
}
?>

<?php
function cardEvent($evento){
    $locandina_evento = $evento["Locandina"];
    if($locandina_evento == "" || !file_exists("upload/" . $locandina_evento)){
        $locandina_evento = "event_default.jpg";
    }
    return '
        <li>
            <a href="./evento.php?idevento=' . $evento["IdEvento"] . '">
                <div class="uk-card uk-card-default uk-margin-bottom">
                    <div class="uk-card-media-top">
                        <div class="uk-height-medium uk-background-cover uk-light" data-src="upload/' . $locandina_evento . '" uk-img="" style="background-image: upload/' . $locandina_evento . '">
                    </div>
                    <div class="uk-card-body"><h3 class="uk-card-title">' . eventCardTitle($evento) . '</h3></div>
                </div>
            </a>
        </li>
    ';
}
?>

<?php
function eventCardTitle($evento){
    if($evento["DataInizio"] == $evento["DataFine"]){
        return $evento["NomeCitta"] . ", " . $evento["DataInizio"];
    } else {
        return $evento["NomeCitta"] . ", dal " . $evento["DataInizio"] . " al " . $evento["DataFine"];
    }
}
?>
