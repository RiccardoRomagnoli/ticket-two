<div uk-grid class="uk-grid-stack uk-flex-center uk-flex-middle">
    <div class="uk-section uk-width-2-3@s uk-width-1-1">
        <div class="uk-container">
            <h2 class="uk-h1">Ciao <?php echo getUserName(); ?>,</h2>
            <span class="uk-text-lead uk-text-center uk-text-left@m">
                Qui puoi vedere le segnalazioni effettuate dagli utenti.
            </span>
        </div>
    </div>
</div>

<hr class="uk-width-1-1 uk-divider-icon uk-margin-medium-bottom">

<div class="uk-width-1-1 uk-margin-remove" uk-grid>

    <div class=" uk-text-center uk-width-expand uk-margin-bottom uk-margin-top uk-padding-remove" uk-grid>
    </div>

    <div class="uk-width-1-1 uk-width-3-5@m uk-margin-bottom uk-margin-top uk-margin-left uk-margin-right uk-margin-bottom uk-padding-remove" uk-grid>
        <?php 
        if(count($templateParams["segnalazioni"]) == 0){
            echo 
                '<div class="uk-card uk-card-default uk-width-1-1">
                    <div class="uk-card-body">
                        <h3 class="uk-card-title uk-margin-remove-top">Ancora nessuna segnalazione</h3>
                    </div>
                </div>';
        } else {
            echo buildAllReports($templateParams["segnalazioni"]); 
        }
        
        ?>
    </div>

    <div class=" uk-text-center uk-width-expand uk-margin-bottom uk-margin-top uk-padding-remove" uk-grid>
    </div>

</div>

<?php 

    function buildAllReports($reports){
        $build = '';
        foreach($reports as $report):
            $build = $build . buildReport($report);
        endforeach;
        return $build;
    }

    function buildReport($report){
        $build = 
            '<div class="uk-card uk-card-default uk-width-1-1">
                <div class="uk-card-body">
                    <a href="./evento.php?idevento=' . $report["IdEvento"] . '">
                        <h3 class="uk-card-title uk-margin-remove-top">' . $report["Titolo"] . '</h3>
                    </a>
                    <p>' . $report["Descrizione"] . '</p>
                </div>
            </div>';
        return $build;
    }

?>