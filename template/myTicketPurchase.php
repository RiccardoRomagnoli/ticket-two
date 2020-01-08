<div uk-grid class="uk-grid-stack uk-flex-center uk-flex-middle">
    <div class="uk-section uk-width-2-3@s uk-width-1-1">
        <div class="uk-container">
            <span class="uk-text-lead uk-text-center">
                Qui puoi vedere tutti i biglietti e gli abbonamenti che hai acquistato per l'evento
                <h2 class="uk-heading-small uk-text-center uk-margin-remove-bottom uk-margin-top"><?php echo $templateParams["evento"][0]["TitoloEvento"];?></h2>
            </span>
        </div>
    </div>
</div>

<hr class="uk-width-1-1 uk-divider-icon uk-margin-medium-bottom">

<div class="uk-width-1-1 uk-margin-remove" uk-grid>

    <div class=" uk-text-center uk-width-expand uk-margin-bottom uk-margin-top uk-padding-remove" uk-grid>
    </div>

    <div class="uk-width-1-1 uk-width-3-5@m uk-margin-bottom uk-margin-top uk-margin-left uk-margin-right uk-margin-bottom uk-padding-remove" uk-grid>
        <?php echo buildAllTickets($templateParams["biglietti"]); ?>
    </div>

    <div class=" uk-text-center uk-width-expand uk-margin-bottom uk-margin-top uk-padding-remove" uk-grid>
    </div>

</div>

<?php

    function buildAllTickets($tickets){
        $build = '';
        foreach($tickets as $ticket):
            $build = $build . buildSingleTicket($ticket);
        endforeach;
        return $build;
    }

    function buildSingleTicket($ticket){
        $build = '
            <div class="uk-card uk-card-default uk-width-1-1">
                <div class="uk-card-body">
                    <h3 class="uk-card-title uk-margin-remove-bottom">Titolare: ' . $ticket["Nome"] . ' ' . $ticket["Cognome"] . '</h3>
                    <p>Data nascita: ' . $ticket["DataNascita"] . '</p>';
        if($ticket["Importo"] == 0 || $ticket["importo"] == ''){
            $build = $build . '
                    <p>Importo: gratuito</p>';
        } else {
            $build = $build . '
                    <p>Importo: ' . $ticket["Importo"] . '€</p>';
        }
        $build = $build . '
                    <p>Tipo biglietto: ' . $ticket["TipoBiglietto"] . '</p>
                    <p>Sezione: ' . $ticket["Sezione"] . '</p>';
        if($ticket["DataInizio"] == $ticket["DataFine"]){
            $build = $build . '
                    <p>' . $ticket["DataInizio"] . ', ore ' . $ticket["Orario"] . '</p>';
        } else {
            $build = $build . '
                    <p>Dal ' . $ticket["DataInizio"] . ' al ' . $ticket["DataFine"] . '</p>';
        }
        $build = $build . '
                </div>
            </div>';
        return $build;
    }

?>

