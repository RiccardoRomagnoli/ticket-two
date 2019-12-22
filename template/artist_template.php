<div class="uk-grid-column-small uk-grid-row-large uk-child-width-1-2@m uk-text-center uk-padding-small uk-padding-remove-top uk-padding-remove-bottom" uk-grid>
    <div>
        <div class="uk-section uk-section-muted">
            <div class="uk-container">
                <?php foreach($templateParams["infoArtista"] as $info): ?>
                    <div>
                        <h1 class="uk-heading-small uk-inline@xl"><?php echo $info["Nome"]; ?></h1>
                        <button class="uk-button uk-button-primary uk-margin-bottom uk-inline@xl">Segui</button>
                    </div>
                    <img src="images/<?php echo $info["Foto"]; ?>" alt="">
                    <p class="uk-text-lead uk-text-left"><?php echo $info["Descrizione"]; ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div>
        <div class="uk-inline">
        <h1 class="uk-heading-line uk-text-center"><span>Eventi programmati</span></h1>
        <div class="uk-grid-column-small uk-grid-row-large uk-child-width-1-2@s uk-text-center uk-padding-small uk-padding-remove-top uk-padding-remove-bottom" uk-grid>
            <?php foreach($templateParams["eventi"] as $evento): ?>
                <div>
                    <div class="uk-inline">
                        <img src="images/<?php echo $evento["Locandina"]; ?>" alt="">
                        <div class="uk-overlay uk-overlay-primary uk-position-bottom">
                            <p>
                                <?php 
                                    echo $evento["NomeCitta"] . ", "; 
                                    if($evento["DataInizio"] == $evento["DataFine"]){
                                        echo $evento["DataInizio"];
                                    } else{
                                        echo "dal " . $evento["DataInizio"] . " al " . $evento["DataFine"];
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>