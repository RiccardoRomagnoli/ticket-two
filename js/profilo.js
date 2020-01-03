$(document).ready(function(){
    $.getScript("./js/sha512.js", function() {});

    var interestsSelected = [];
    var interestInserted = 0;

    $(".remove_card").click(function(){
        var IdPagamento  = $(this).val();

        $.post("utils/remove-payment.php",
            {IdPagamento: IdPagamento},
            function(data, status){checkRemoveResult(JSON.parse(data));} );
    });

    $(".removeInterestBtn").click(function(){
        var IdInteresse  = $(this).val();

        $.post("utils/remove-interest.php",
            {IdInteresse: IdInteresse},
            function(data, status){checkRemoveResult(JSON.parse(data));} );
    });

    $("#addPaymentBtn").click(function(){
        var Titolare  = $("#titolare").val();
        var Numero  = $("#numero").val();
        var Data  = ($("#data").val()).split("/");

        $.post("utils/insert-payment.php",
            {Titolare: Titolare, Numero:Numero, Anno:Data[1], Mese:Data[0]},
            function(data, status){checkInsertResult(JSON.parse(data));} );
    });

    $(".addInterestCheck").change(function(){
        // this will contain a reference to the checkbox   
        if (this.checked) {
            interestsSelected.push($(this).val());
        } else {
            var index = interestsSelected.indexOf($(this).val());
            if (index > -1) {
                interestsSelected.splice(index, 1);
            }
        }
    });

    $("#addInterestBtn").click(function(){
        interestsSelected.forEach(element => {
            $.post("utils/insert-interest.php",
                   {IdCategoria: element}, 
                   function(data, status){checkInsertInterestResult(JSON.parse(data));} );
        });
    });

    $("#updateInfoBtn").click(function(){
        var Nome = $("#nome").val();
        var Cognome = $("#cognome").val();
        var Email = $("#email").val();
        var Password = SHA512($("#password").val());
        var NewPassword = SHA512($("#new-password").val());

            $.post("utils/update-info.php",
                   {Nome: Nome, Cognome:Cognome, Email:Email, Password:Password, NewPassword:NewPassword}, 
                   function(data, status){checkUpdateResult(JSON.parse(data));} );
    });

    function checkInsertInterestResult(response){
        interestInserted++;
        if(interestInserted == interestsSelected.length){
            if(response.result == "ok"){
                UIkit.notification({
                    message: '<span uk-icon="icon: check"></span> '+response.message,
                    status: 'success',
                    pos: 'top-right'
                });
                window.setTimeout(function(){location.reload()},1000);
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

    }
    
    function checkRemoveResult(response){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
            });
            window.setTimeout(function(){location.reload()},1000);
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

    function checkInsertResult(response){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
            });
            window.setTimeout(function(){location.reload()},1000);
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

    function checkUpdateResult(response){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
            });
            window.setTimeout(function(){location.reload()},1000);
        }else if(response.result == "warning"){
            UIkit.notification({
                message: '<span uk-icon="icon: close"></span> '+response.message,
                status: 'warning',
                pos: 'top-right',
                timeout: 2500
            });
        }else {
            UIkit.notification({
                message: '<span uk-icon="icon: close"></span> '+response.message,
                status: 'danger',
                pos: 'top-right',
                timeout: 2500
            });
        }
    }
});