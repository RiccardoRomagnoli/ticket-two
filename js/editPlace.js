$(document).ready(function(){

    $("#saveBtn").click(function(){

        if($("#name").val().trim() != ""){
            const placeName = $("#name").val().trim();
            const placeDescription = $("#description").val().trim();
            const idPlace = document.getElementById('idPlace').value;
            $.post("utils/editPlace.php",
            {action: 'update', idPlace: idPlace, name: placeName, description: placeDescription}, 
            function(data, status){checkUpdateResult(JSON.parse(data), idPlace);});
            
        } else {
            UIkit.notification({
                message: '<span uk-icon="icon: close">Completa i campi obbligatori (*)</span> ',
                status: 'warning',
                pos: 'top-right',
                timeout: 2500
            });
        }
    });

    function checkUpdateResult(response, idPlace){
        if(response.result == "ok"){
            setTimeout(function(){
                location.replace("place.php?id=".concat(idPlace));
            }, 1000);
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right',
                timeout: 1000
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

    $("#deleteBtn").click(function(){
        if(document.getElementById('idPlace').value != undefined){
            const idPlace = document.getElementById('idPlace').value;
            $.post("utils/editPlace.php",
            {action: 'delete', idPlace: idPlace}, 
            function(data, status){checkDeleteResult(JSON.parse(data));});
        } else {
            setTimeout(function(){
                location.replace("index.php");
            }, 1500);
            UIkit.notification({
                message: '<span uk-icon="icon: close">Errore</span> ',
                status: 'error',
                pos: 'top-right',
                timeout: 1500
            });
        }
    });

    function checkDeleteResult(response){
        if(response.result == "ok"){
            setTimeout(function(){
                location.replace("index.php");
            }, 1500);
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