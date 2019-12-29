$(document).ready(function(){
    $(".datanascita").flatpickr({});

    $(".save").click(function(){
        var IdRigaCarrello  = $(this).val();
        var Nome = $("#nome"+IdRigaCarrello).val();
        var Cognome = $("#cognome"+IdRigaCarrello).val();
        var DataNascita = $("#datanascita"+IdRigaCarrello).val();

        $.post("utils/update-cart.php",
            {IdRigaCarrello: IdRigaCarrello, Nome:Nome, Cognome:Cognome, DataNascita:DataNascita},
            function(data, status){checkResult(JSON.parse(data));} );
    });

    $(".remove").click(function(){
        var IdRigaCarrello  = $(this).val();

        $.post("utils/remove-cart.php",
            {IdRigaCarrello: IdRigaCarrello},
            function(data, status){checkResult(JSON.parse(data)); window.setTimeout(function(){location.reload()},1000);}
        );
    });

    function checkResult(response){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
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

