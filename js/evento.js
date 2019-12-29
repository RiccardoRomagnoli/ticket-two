$(document).ready(function(){

    const idUser  = $("#idUser").val();
    const idEvent = $("#idEvent").val();
    
    $("#followBtn").click(function(){
        if( $("#followBtn").text() == "Segui"){
             $.post("utils/follow-event.php",
                 {idUser: idUser, idEvent: idEvent, follow: "true"},
                 function(data, status){checkFollowResult(JSON.parse(data));});
        } else {
            $.post("utils/follow-event.php",
                {idUser: idUser, idEvent: idEvent, follow: "false"},
                function(data, status){checkUnFollowResult(JSON.parse(data));});
        }
    });
    
    function checkFollowResult(response){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
            });
            $("#followBtn").text("Non seguire più");
        }else if(response.result == "warning"){
            UIkit.notification({
                message: '<span uk-icon="icon: close"></span> '+response.message,
                status: 'warning',
                pos: 'top-right',
                timeout: 2500
            });
        }else{
            UIkit.notification({
                message: '<span uk-icon="icon: close"></span> '+response.message,
                status: 'danger',
                pos: 'top-right',
                timeout: 2500
            });
        }
    }

    function checkUnFollowResult(response){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
            });
            $("#followBtn").text("Segui");
        }else if(response.result == "warning"){
            UIkit.notification({
                message: '<span uk-icon="icon: close"></span> '+response.message,
                status: 'warning',
                pos: 'top-right',
                timeout: 2500
            });
        }else{
            UIkit.notification({
                message: '<span uk-icon="icon: close"></span> '+response.message,
                status: 'danger',
                pos: 'top-right',
                timeout: 2500
            });
        }
    }
});