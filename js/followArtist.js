$(document).ready(function(){
    $("#followBtn").click(function(){
        if(document.getElementById("followBtn").innerHTML == "Segui"){
            $actionToExecute = 'follow';
        } else {
            $actionToExecute = 'unfollow';
        }
        $.post("utils/followArtist.php",
        {idArtist: document.getElementById('idArtist').value, idUser: document.getElementById('idUser').value, action: $actionToExecute}, 
        function(data, status){checkFollowResult(JSON.parse(data));});
    });

    function checkFollowResult(response){
        if(response.result == "ok"){
            if(document.getElementById("followBtn").innerHTML == "Segui"){
                document.getElementById("followBtn").innerHTML = "Segui già";
            } else {
                document.getElementById("followBtn").innerHTML = "Segui";
            }
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right',
                timeout: 1500
            });
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