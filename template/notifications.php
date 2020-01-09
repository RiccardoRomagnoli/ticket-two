<script src="js/notifications.js"></script>

<div uk-grid class="uk-grid-stack uk-flex-center uk-flex-middle">
    <div class="uk-section uk-width-2-3@s uk-width-1-1">
        <div class="uk-container">
            <h1 class="uk-h1">Ciao <?php echo getUserName(); ?>,</h1>
            <span class="uk-text-lead uk-text-center uk-text-left@m">
                Qui puoi vedere le tue notifiche.
            </span>
        </div>
    </div>
</div>

<hr class="uk-width-1-1 uk-divider-icon uk-margin-medium-bottom">

<h2 class="uk-h1 uk-text-center">Notifiche da leggere</h2>

<div class="uk-width-1-1 uk-margin-remove" uk-grid>

    <div class=" uk-text-center uk-width-expand uk-margin-bottom uk-margin-top uk-padding-remove" uk-grid>
    </div>

    <div class="uk-width-1-1 uk-width-3-5@m uk-margin-bottom uk-margin-top uk-margin-left uk-margin-right uk-margin-bottom uk-padding-remove" id="notReadedGrid" uk-grid>
        <?php 
        if(count($templateParams["notificheDaLeggere"]) == 0){
            echo 
                '<div class="uk-card uk-card-default uk-width-1-1">
                    <div class="uk-card-body">
                        <h3 class="uk-card-title uk-margin-remove-top">Nessuna notifica ancora da leggere</h3>
                    </div>
                </div>';
        } else {
            echo buildAllNotReadedNotifications($templateParams["notificheDaLeggere"]); 
        }
        
        ?>
    </div>

    <div class=" uk-text-center uk-width-expand uk-margin-bottom uk-margin-top uk-padding-remove" uk-grid>
    </div>

</div>

<hr class="uk-width-1-1 uk-divider-icon uk-margin-medium-bottom">

<h2 class="uk-h1 uk-text-center">Notifiche lette</h2>

<div class="uk-width-1-1 uk-margin-remove" uk-grid>

    <div class=" uk-text-center uk-width-expand uk-margin-bottom uk-margin-top uk-padding-remove" uk-grid>
    </div>

    <div class="uk-width-1-1 uk-width-3-5@m uk-margin-bottom uk-margin-top uk-margin-left uk-margin-right uk-margin-bottom uk-padding-remove" id="readedGrid"uk-grid>
        <?php 
        if(count($templateParams["notificheLette"]) == 0){
            echo 
                '<div class="uk-card uk-card-default uk-width-1-1" id="noNotReadedNotifications">
                    <div class="uk-card-body">
                        <h3 class="uk-card-title uk-margin-remove-top">Nessuna notifica già letta</h3>
                    </div>
                </div>';
        } else {
            echo buildAllReadedNotifications($templateParams["notificheLette"]); 
        }
        ?>
    </div>

    <div class=" uk-text-center uk-width-expand uk-margin-bottom uk-margin-top uk-padding-remove" uk-grid>
    </div>

</div>

<?php

    function buildAllNotReadedNotifications($notifications){
        $build = '';
        foreach($notifications as $notification):
            $build = $build . buildSingleNotReadedNotification($notification);
        endforeach;
        return $build;
    }

    function buildSingleNotReadedNotification($notification){
        $build = 
            '<div class="uk-card uk-card-default uk-width-1-1" id = "notification' . $notification["IdNotifica"] . '">
                <div class="uk-card-body">
                    <p>' . $notification["Data"] . '</p>
                    <h3 class="uk-card-title uk-margin-remove-top">' . $notification["Testo"] . '</h3>
                    <div class = "uk-flex uk-flex-right" id="notificationButtonDiv' . $notification["IdNotifica"] . '">
                        <button class="uk-button uk-button-primary" onclick="makeNotificationReaded(' . $notification["IdNotifica"] . ')">Ok</button>
                    </div>
                </div>
            </div>';
        return $build;
    }

    function buildAllReadedNotifications($notifications){
        $build = '';
        foreach($notifications as $notification):
            $build = $build . buildSingleReadedNotification($notification);
        endforeach;
        return $build;
    }

    function buildSingleReadedNotification($notification){
        $build = 
            '<div class="uk-card uk-card-default uk-width-1-1" id = "notification' . $notification["IdNotifica"] . '">
                <div class="uk-card-body">
                    <p>' . $notification["Data"] . '</p>
                    <h3 class="uk-card-title uk-margin-remove-top">' . $notification["Testo"] . '</h3>
                    <div class = "uk-flex uk-flex-right" id="notificationButtonDiv' . $notification["IdNotifica"] . '">
                        <button class="uk-button uk-button-danger" onclick="deleteReadedNotification(' . $notification["IdNotifica"] . ')">Elimina</button>
                    </div>
                </div>
            </div>';
        return $build;
    }

?>