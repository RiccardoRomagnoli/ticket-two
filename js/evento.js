$(document).ready(function(){

    const idUser  = $("#idUser").val();
    const idEvent = $("#idEvent").val();
    let idCart = $("#idCart").val();
    const nTickets = $("#nTickets").val();
    const nAbbonamenti = $("#nAbbonamenti").val();

    //bottoni acquisto ticket
    for(let countt = 1; countt <= nTickets; countt++){
        $("#aggiungiTicket" + countt).click(function(){
            let nTicketAquistati = $("#numeroTicket" + countt).val();
            let idBiglietto = $("#idBiglietto" + countt).val();
            
            //carrello non esiste creo riga sul db
            if(idCart == 0){
                $.post("utils/event-cart.php",
                 {idUser: idUser, azione: "creaCart"},
                 function(data){
                    idCart = data;
                    //aggiungo righe al carrello in base alla quantità
                    for(let c=0; c<nTicketAquistati; c++){
                        $.post("utils/event-cart.php",
                        {idCart: idCart, idBiglietto: idBiglietto, azione: "acquistoBiglietto"},
                        function(data){checkBuyResult(JSON.parse(data));});
                    }});
            } else {
                //aggiungo righe al carrello in base alla quantità
                for(let c=0; c<nTicketAquistati; c++){
                    $.post("utils/event-cart.php",
                    {idCart: idCart, idBiglietto: idBiglietto, azione: "acquistoBiglietto"},
                    function(data){checkBuyResult(JSON.parse(data));});
                }
            }
        });
    }

    //bottoni acquisto abbonamenti
    for(let counta = 1; counta <= nAbbonamenti; counta++){
        $("#aggiungiAbbonamento" + countt).click(function(){
            let nAbbonamentiAquistati = $("#numeroAbbonamento" + counta).val();
            let idAbbonamento = $("#idAbbonamento" + counta).val();
            
            //carrello non esiste creo riga sul db
            if(idCart == 0){
                $.post("utils/event-cart.php",
                 {idUser: idUser, azione: "creaCart"},
                 function(data){idCart = data});
            }

            //aggiungo righe al carrello in base alla quantità
            for(let cc=0; cc<nAbbonamentiAquistati; cc++){
                $.post("utils/event-cart.php",
                {idCart: idCart, idBiglietto: idAbbonamento, azione: "acquistoBiglietto"},
                function(data, status){checkBuyResult(JSON.parse(data));});
            }
        });
    }

    //bottone follow/unfollow
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
    

    //check buy result
    function checkBuyResult(response){
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
    //check follow result
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

    //check unfollow result
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