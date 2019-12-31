<div uk-grid class="uk-grid-stack uk-flex-center uk-flex-middle">
    <div class="uk-section uk-width-2-3@s uk-width-1-1">
        <div class="uk-container">
            <h1 class="uk-h1">Ciao <?php echo getUserName(); ?>,</h1>
            <span class="uk-text-lead uk-text-center uk-text-left@m">
                Qui puoi vedere tutti i biglietti e gli abbonamenti che hai acquistato.
            </span>
        </div>
    </div>
</div>

<hr class="uk-width-1-1 uk-divider-icon uk-margin-medium-bottom">

<?php 
if(count($templateParams["eventi"])==0){
    echo '
    <div uk-grid class="uk-grid-stack uk-flex-center uk-flex-middle">
        <div class="uk-section uk-width-2-3@s uk-width-1-1">
            <div class="uk-container">
                <span class="uk-text-lead uk-text-center uk-text-left@m">
                    Non hai ancora acquistato nessun biglietto o abbonamento.
                </span>
            </div>
        </div>
    </div>
    ';
} else {
    echo '
    <div class="uk-width-1-1 uk-margin-remove" uk-grid>

        <div class=" uk-text-center uk-width-expand uk-margin-bottom uk-margin-top uk-padding-remove" uk-grid>
        </div>

        <div class=" uk-text-center uk-width-1-1 uk-width-3-5@m uk-margin-bottom uk-margin-top uk-margin-left uk-margin-right uk-padding-remove" uk-grid>' .
            getEventCards($templateParams["eventi"])
        . '</div>

        <div class=" uk-text-center uk-width-expand uk-margin-bottom uk-margin-top uk-padding-remove" uk-grid>
        </div>

    </div>
    ';
}

function getEventCards($eventi){
    $build = '';
    foreach($eventi as $evento):
        $build = $build . 
            '<div class="uk-container uk-width-1-1 uk-width-1-2@s">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-media-top">
                        <div class="uk-height-medium uk-background-cover uk-light" data-src="upload/' . $evento["Locandina"] . '" uk-img="" style="background-image: upload/' . $evento["Locandina"] . '"></div>
                    </div>
                    <div class="uk-card-body">
                        <p>' . $evento["Titolo"] . '</p>
                    </div>
                </div>
            </div>';
    endforeach;
    return $build;
}

?>
