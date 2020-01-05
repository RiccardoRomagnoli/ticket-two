function makeNotificationReaded(idNotification) {
    document.getElementById("notificationButtonDiv" + idNotification).innerHTML = '<button class="uk-button uk-button-danger" onclick="deleteReadedNotification(' + idNotification + ')">Elimina</button>';
    if(document.getElementById("noNotReadedNotifications") != null){
        document.getElementById("readedGrid").innerHTML = '';
    }
    jQuery("#notification" + idNotification).detach().prependTo('#readedGrid');
    $.post("utils/notifications.php",
        {action: 'read', idNotification: idNotification}, 
        function(data, status){});
    if($("#notReadedGrid div").length == 0){
        document.getElementById("notReadedGrid").innerHTML = '<div class="uk-card uk-card-default uk-width-1-1"><div class="uk-card-body"><h3 class="uk-card-title uk-margin-remove-top">Nessuna notifica ancora da leggere</h3></div></div>';
    }
}

function deleteReadedNotification(idNotification){
    document.getElementById("notification" + idNotification).remove();
    $.post("utils/notifications.php",
        {action: 'delete', idNotification: idNotification}, 
        function(data, status){});
    if($("#readedGrid div").length == 0){
        document.getElementById("readedGrid").innerHTML = '<div class="uk-card uk-card-default uk-width-1-1" id="noNotReadedNotifications"><div class="uk-card-body"><h3 class="uk-card-title uk-margin-remove-top">Nessuna notifica già letta</h3></div></div>';
    }
}
    