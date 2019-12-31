<!-- pagina evento base -->

<!-- controlli iniziali -->
<?php
    $nome_luogo = $templateParams["infoLuogo"][0]["Nome"];
    if($nome_luogo == ""){
        $nome_luogo = "Nome assente";
    }
    $descrizione_luogo = $templateParams["infoLuogo"][0]["Descrizione"];
    if($descrizione_luogo == ""){
        $descrizione_luogo = "Nessuna descrizione disponibile per questo luogo";
    }
    $citta = $templateParams["infoLuogo"][0]["NomeCitta"];
    $provincia = $templateParams["infoLuogo"][0]["NomeProvincia"];
    $regione = $templateParams["infoLuogo"][0]["NomeRegione"];
?>

<!-- nome luogo e pulsante -->
<div class="uk-grid uk-text-center uk-margin-bottom uk-grid-collapse uk-width-1-1">
    <div class="uk-panel uk-width-1-1 uk-width-1-2@m">
        <div class="uk-grid uk-text-center uk-grid-collapse uk-width-1-1">
            <div class="uk-panel uk-width-0-0 uk-width-1-6@m">
            </div>
            <div class="uk-panel uk-width-1-1 uk-width-5-6@m">
                <h1 class="uk-heading-small uk-width-1-1 uk-text-left@m"><?php echo $nome_luogo; ?></h1>
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

<!-- descrizione luogo -->
<div class="uk-grid-column-small uk-grid-row-large uk-child-width-1-1 uk-text-center uk-margin-remove-top" uk-grid>
    <div>
        <div class="uk-container">
            <div class="uk-card uk-card-default">
                <div class="uk-card-body">
                    <ul uk-accordion>
                        <li class="uk-open">
                            <a class="uk-accordion-title" href="#">Su questo posto</a>
                            <div class="uk-accordion-content">
                                <p><?php echo $citta . " (" . $provincia . "), " . $regione ?></p>
                                <p><?php echo $descrizione_luogo; ?></p>
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
