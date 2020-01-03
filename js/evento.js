$(document).ready(function(){

    const idEvent = $("#idEvent").val();
    const nTickets = $("#nTickets").val();
    const nAbbonamenti = $("#nAbbonamenti").val();

    const fp = flatpickr("#dataFineModifica", {
        minDate: "today",
    });

    $("#nomeLuogo").select2({
        placeholder: "Seleziona un luogo"
    });
    
    $("#dataInizioModifica").flatpickr({
        onChange: function(selectedDates, dateStr, instance) {
            fp.set("minDate", dateStr);
            fp.setDate(dateStr);
        },
        minDate: "today",
    });

    $("#modificaEventoForm").submit(function(e) {
        e.preventDefault();
        let titolo = $("#nomeEvento").val();
        let dataInizio = $("#dataInizioModifica").val();
        let dataFine = $("#dataFineModifica").val();
        let descrizione = $("#descrizioneEvento").val();
        let fotoLocation = $("#pathLocandina").val();
        let nomeLuogo = $("#nomeLuogo").val();
        $.post(
            "utils/event-cart.php",
            {
                azione: "modificaEvento", idEvento: idEvent, titolo: titolo, dataInizio: dataInizio,
                dataFine: dataFine, descrizione: descrizione, fotoLocation: fotoLocation,
                nomeLuogo: nomeLuogo
            },
            function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok") {
                    window.setTimeout(function(){location.reload()},1500);
                }
            });
    });

    //bottoni acquisto ticket
    for(let countt = 1; countt <= nTickets; countt++){
        $("#aggiungiTicket" + countt).click(function(){
            let nTicketAquistati = $("#numeroTicket" + countt).val();
            let idBiglietto = $("#idBiglietto" + countt).val();
            
            //carrello non esiste creo riga sul db
            $.post("utils/event-cart.php",
                {azione: "creaCart"},
                function(data){
                    idCart = data;
                    //aggiungo righe al carrello in base alla quantità
                    for(let c=0; c<nTicketAquistati; c++){
                        $.post("utils/event-cart.php",
                            {idCart: idCart, idBiglietto: idBiglietto, azione: "acquistoBiglietto"},
                            function(data){checkEvento(JSON.parse(data));}
                        );
                    }
                }
            );
        });
    }

    //bottoni acquisto abbonamenti
    for(let counta = 1; counta <= nAbbonamenti; counta++){
        $("#aggiungiAbbonamento" + counta).click(function(){
            let nAbbonamentiAquistati = $("#numeroAbbonamento" + counta).val();
            let idAbbonamento = $("#idAbbonamento" + counta).val();
            
            //carrello non esiste creo riga sul db
            $.post("utils/event-cart.php",
                {azione: "creaCart"},
                function(data){
                    idCart = data;
                    //aggiungo righe al carrello in base alla quantità
                    for(let cc=0; cc<nAbbonamentiAquistati; cc++){
                        $.post("utils/event-cart.php",
                            {idCart: idCart, idBiglietto: idAbbonamento, azione: "acquistoBiglietto"},
                            function(data){checkEvento(JSON.parse(data));}
                        );
                    }
                }
            );
        });
    }

    //bottone follow/unfollow
    $("#followBtn").click(function(){
        if( $("#followBtn").text() == "Segui"){
             $.post("utils/follow-event.php",
                 {idEvent: idEvent, follow: "true"},
                 function(data){
                    checkEvento(JSON.parse(data));
                    if(JSON.parse(data).result == "ok"){
                        $("#followBtn").text("Non seguire più");
                    }
                    });
        } else {
            $.post("utils/follow-event.php",
                {idEvent: idEvent, follow: "false"},
                function(data){
                    checkEvento(JSON.parse(data));
                    if(JSON.parse(data).result == "ok") {
                        $("#followBtn").text("Segui");
                    }
                });
        }
    });

    $("#deleteEventBtn").click(function(){
        $.post(
            "utils/event-cart.php",
            {
                azione: "eliminaEvento", idEvento: idEvent
            },
            function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok"){
                    window.setTimeout(function(){location.reload()},1500);
                }
            });
    });
    
    //check eventi
    function checkEvento(response){
        if(response.result == "ok"){
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