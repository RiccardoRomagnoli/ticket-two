<!-- sezione eventi 1 -->
<h2 class="uk-h1 uk-text-center"><?php echo $templateParams["titoloEventi1"]; ?></h1>
<?php echo eventsSliderTop($templateParams["eventi1"]); ?>
<hr class="uk-width-1-1 uk-divider-icon uk-margin-medium-bottom">
<!-- sezione eventi 2 -->
<h2 class="uk-h1 uk-text-center"><?php echo $templateParams["titoloEventi2"]; ?></h1>
<?php echo eventsSliderTop($templateParams["eventi2"]); ?>
<hr class="uk-width-1-1 uk-divider-icon uk-margin-medium-bottom">
<!-- categorie eventi -->
<h2 class="uk-h1 uk-text-center">Eventi per categoria</h1>
<div class="uk-section">
    <div class="uk-container">
        <ul uk-accordion>
            <?php
                foreach($templateParams["categorie"] as $categoria):
                    echo categoryAccordion($categoria->nome, $categoria->eventiCategoria);
                endforeach;
            ?>
        </ul>
    </div>
</div>

<?php 

    function categoryAccordion($categoryName, $categoryEvents){
        return '
            <li>
                <a class="uk-accordion-title" href=#>' . $categoryName . '</a>
                <div class="uk-accordion-content">'
                    . eventsSlider($categoryEvents) . 
                '</div>
            </li>';
    }

    function eventsSliderTop($eventi){
        if (count($eventi) > 0){
            $build = 
                '<div uk-slider="center: true; autoplay: true; autoplay-interval: 2500; pause-on-hover: true">
                    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
                        <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-child-width-1-4@l uk-grid">';
            foreach($eventi as $evento):
                $build = $build . 
                            cardEvent($evento);
            endforeach;
            return $build . '
                        </ul>
                        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous" title="precedente"></a>
                        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next" title="successivo"></a>
                    </div>
                    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
                </div>';
        } else {
            return 
                '<div class="uk-card uk-card-default uk-margin-bottom uk-margin-left uk-margin-right">
                    <div class="uk-card-body uk-height-small uk-text-center uk-flex uk-flex-center uk-flex-middle"><h3 class="uk-card-title">Nessun evento al momento</h3></div>
                </div>';
        }
        
    }

    function eventsSlider($eventi){
        if (count($eventi) > 0){
            $build = 
                '<div uk-slider="center: true;">
                    <div class="uk-position-relative uk-visible-toggle uk-light" tabindex="-1">
                        <ul class="uk-slider-items uk-child-width-1-1 uk-child-width-1-2@s uk-child-width-1-3@m uk-grid">';
            foreach($eventi as $evento):
                $build = $build . 
                            cardEvent($evento);
            endforeach;
            return $build . '
                        </ul>
                        <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous" title="precedente"></a>
                        <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next" title="successivo"></a>
                    </div>
                <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
            </div>';
        } else {
            return 
                '<div class="uk-card uk-card-default uk-margin-bottom">
                    <div class="uk-card-body uk-height-small uk-text-center uk-flex uk-flex-center uk-flex-middle"><h3 class="uk-card-title">Nessun evento al momento</h3></div>
                </div>';
        }
    }

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
                        <div class="uk-card-body uk-height-small uk-text-center uk-flex uk-flex-center uk-flex-middle">
                            <h3 class="uk-card-title">' . $evento["Titolo"] . '</br>' . eventCardTitle($evento) . '</h3>
                        </div>
                    </div>
                </a>
            </li>
        ';
    }

    function eventCardTitle($evento){
        if($evento["DataInizio"] == $evento["DataFine"]){
            return $evento["NomeCitta"] . ", " . $evento["DataInizio"];
        } else {
            return $evento["NomeCitta"] . ", dal " . $evento["DataInizio"] . " al " . $evento["DataFine"];
        }
    }

?>
