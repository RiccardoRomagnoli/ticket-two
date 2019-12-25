$(document).ready(function(){

    $(".remove_card").click(function(){
            var IdPagamento  = $(this).val();

            $.post("utils/remove-payment.php",
                {IdPagamento: IdPagamento},
                function(data, status){checkRemoveResult(JSON.parse(data));} );
    });

    $(".removeInterestBtn").click(function(){
        var IdInteresse  = $(this).val();
        alert(IdInteresse);

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

    function checkRemoveResult(response){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
            });
            window.setTimeout(function(){location.reload()},1000);
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