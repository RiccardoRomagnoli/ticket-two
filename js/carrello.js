$(document).ready(function(){
    $.getScript("./js/sha512.js", function() {});
    var GuestId;


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

    $("#paga").click(function(){
        var IdAcquisto  = $(this).val();
        var CVC = $("#codice").val();

        if ( $( "#email" ).length ) {
            var Email  = $("#email").val();

            $.post("utils/pay-cart.php",
            {IdAcquisto:IdAcquisto, Email:Email, codice:CVC},
            function(data, status){checkPaymentResultAndSingUp(JSON.parse(data), IdAcquisto);}
            );
        }else{
            $.post("utils/pay-cart.php",
            {IdAcquisto:IdAcquisto, codice:CVC},
            function(data, status){checkPaymentResult(JSON.parse(data), IdAcquisto);}
            );
        }
    });

    $("#addPaymentBtn").click(function(){
        var Titolare  = $("#titolare").val();
        var Numero  = $("#numero").val();
        var Data  = ($("#data").val()).split("/");
        
        if ( $( "#email" ).length ) {
            $("#titolare").val("");
            $("#numero").val("");
            $("#data").val("");
            $( "#carta" ).append("<option>************"+Numero.substring(Numero.length - 4, Numero.length)+
                                 " - "+Data[1]+"/"+Data[0]+"</option>");
            UIkit.modal("#add-payment").hide();
        }else{
            $.post("utils/insert-payment.php",
            {Titolare: Titolare, Numero:Numero, Anno:Data[1], Mese:Data[0]},
            function(data, status){checkInsertPaymentResult(JSON.parse(data), Numero, Data);} );
        }

    });

    $("#crea").click(function(){
        var Password = SHA512($("#passwordPay").val());

        $.post("utils/singup-guest.php",
        {Password:Password, GuestId:GuestId},
        function(data, status){checkResult(JSON.parse(data));}
        );
        UIkit.modal("#pay-success-register").hide();
        window.setTimeout(function(){location.reload()},1000);
    });

    function checkInsertPaymentResult(response, Numero, Data){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
            });
            $("#titolare").val("");
            $("#numero").val("");
            $("#data").val("");
            $( "#carta" ).append("<option value="+response.id+
                                 ">************"+Numero.substring(Numero.length - 4, Numero.length)+
                                 " - "+Data[1]+"/"+Data[0]+"</option>");
            UIkit.modal("#add-payment").hide();
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

    function checkResult(response){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
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

    function checkPaymentResult(response, IdAcquisto){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
            });

            UIkit.modal("#pay-success").show();
            $.post("utils/sendmail-tickets.php",
            {IdAcquisto:IdAcquisto},
            function(data, status){console.log(data);}
            );
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

    function checkPaymentResultAndSingUp(response, IdAcquisto){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
            });
            UIkit.modal("#pay-success-register").show();
            GuestId = response.id;

            $.post("utils/sendmail-tickets.php",
            {IdAcquisto:IdAcquisto},
            function(data, status){console.log(data);}
            );
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

