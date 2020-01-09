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

    $("#procedi").click(function(e){
        e.preventDefault();
        var flag = true;

        let nomi =  $(".nome");
        let cognomi =  $(".cognome");
        let datanascita =  $(".datanascita");

        nomi.each(function(){
            if($(this).val() == "")
            flag = false;
        });
        cognomi.each(function(){
            if($(this).val() == "")
            flag = false;
        });
        datanascita.each(function(){
            if($(this).val() == "")
            flag = false;
        });

        if(flag)
            UIkit.modal("#modal-buy").show();
        else{
            UIkit.notification({
                message: '<span uk-icon="icon: close"></span> '+'Verifica che tutti i biglietti abbiano un nominativo!',
                status: 'warning',
                pos: 'top-right',
                timeout: 2500
            });
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
        
        var Password = $("#passwordPay").val();
        if(Password.length > 5){
            Password = SHA512(Password);
            $.post("utils/singup-guest.php",
            {Password:Password, GuestId:GuestId},
            function(data, status){checkResultSingupGuest(JSON.parse(data));}
            );
        }else{
            UIkit.notification({
                message: 'Inserisci almeno 6 caratteri',
                status: 'warning',
                pos: 'top-right'
            });
        }
    });

    function checkResultSingupGuest(response){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
            });
            UIkit.modal("#pay-success-register").hide();
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

