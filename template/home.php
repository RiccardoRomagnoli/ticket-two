<!-- categorie eventi -->
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

    function eventsSlider($eventi){
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
                    <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                    <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slider-item="next"></a>
                </div>
            <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
        </div>';
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
                        <div class="uk-card-body"><h3 class="uk-card-title">' . eventCardTitle($evento) . '</h3></div>
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
