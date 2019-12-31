$(document).ready(function(){

    jQuery("input#fileToUpload").change(function () {
        if(jQuery(this).val() != ""){
            $("#fileToUpload").prop("disabled",true);
            $("#saveBtn").prop("disabled",true);
            var file_data = $('#fileToUpload').prop('files')[0];   
            var form_data = new FormData();                  
            form_data.append('file', file_data);                           
            $.ajax({
                url: 'utils/fileHandler.php',
                dataType: 'text',
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,                         
                type: 'post',
                success: function(php_script_response){
                    if(php_script_response ==""){
                        var artistFotoFileName;
                        if(getFileNameFromPath(document.getElementById('fileToUpload').value) == ''){
                            artistFotoFileName = document.getElementById('savedFoto').value;
                        } else {
                            artistFotoFileName = getFileNameFromPath(document.getElementById('fileToUpload').value);
                        }
                        document.getElementById("editFoto").src="upload/".concat(artistFotoFileName);
                        UIkit.notification({
                            message: '<span uk-icon="icon: check">File caricato</span> ',
                            status: 'success',
                            pos: 'top-right',
                            timeout: 1000
                        });
                    } else {
                        UIkit.notification({
                            message: '<span uk-icon="icon: close">Problema nel caricamento file</span> ',
                            status: 'warning',
                            pos: 'top-right',
                            timeout: 2500
                        });
                    }
                    $("#fileToUpload").prop("disabled",false);
                    $("#saveBtn").prop("disabled",false);
                }
            });
        }
    });

    $("#saveBtn").click(function(){

        if($("#name").val().trim() != ""){
            const artistName = $("#name").val().trim();
            const artistDescription = $("#description").val().trim();
            var artistFotoFileName;
            if(getFileNameFromPath(document.getElementById('fileToUpload').value) == ''){
                artistFotoFileName = document.getElementById('savedFoto').value;
            } else {
                artistFotoFileName = getFileNameFromPath(document.getElementById('fileToUpload').value);
            }
            const idArtist = document.getElementById('idArtist').value;
            $.post("utils/editArtist.php",
            {action: 'update', idArtist: idArtist, name: artistName, description: artistDescription, foto: artistFotoFileName}, 
            function(data, status){checkUpdateResult(JSON.parse(data), idArtist);});
            
        } else {
            UIkit.notification({
                message: '<span uk-icon="icon: close">Completa i campi obbligatori (*)</span> ',
                status: 'warning',
                pos: 'top-right',
                timeout: 2500
            });
        }
    });

    function getFileNameFromPath(filePath){
        filePath = filePath.substring(filePath.lastIndexOf("\\") + 1);
        return filePath.substring(filePath.lastIndexOf("/") + 1);
    }

    function checkUpdateResult(response, idArtist){
        if(response.result == "ok"){
            setTimeout(function(){
                location.replace("artist.php?id=".concat(idArtist));
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
        if(document.getElementById('idArtist').value != undefined){
            const idArtist = document.getElementById('idArtist').value;
            $.post("utils/editArtist.php",
            {action: 'delete', idArtist: idArtist}, 
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