$(document).ready(function(){

    const idEvent = $("#idEvent").val();

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

    //sezione model modificaEvento

    $("#modificaEventoForm").submit(function(e) {
        e.preventDefault();
        let titolo = $("#nomeEvento").val();
        let dataInizio = $("#dataInizioModifica").val();
        let dataFine = $("#dataFineModifica").val();
        let descrizione = $("#descrizioneEvento").val();
        let fotoLocation = $("#pathLocandina").val();
        let idLuogo = $("#idLuogo").val();
        $.post(
            "utils/event-cart.php",
            {
                azione: "modificaEvento", idEvento: idEvent, titolo: titolo, dataInizio: dataInizio,
                dataFine: dataFine, descrizione: descrizione, fotoLocation: fotoLocation,
                idLuogo: idLuogo
            },
            function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok") {
                    window.setTimeout(function(){location.reload()},1500);
                }
            });
    });

    $("#idLuogo").select2({
        placeholder: "Seleziona un luogo"
    });

    const fp = flatpickr("#dataFineModifica", {
        minDate: "today",
    });

    $("#dataInizioModifica").flatpickr({
        onChange: function(selectedDates, dateStr, instance) {
            fp.set("minDate", dateStr);
            fp.setDate(dateStr);
        },
        minDate: "today",
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

    //sezione model modificaBiglietto

    $("#modificaBigliettoForm").submit(function(e) {
        e.preventDefault();
        let idBiglietto = $("#idBigliettoModifica").val();
        let idSezioneEvento = $("#idSezioneEvento").val();
        let dataInizioBiglietto = $("#dataInizioBiglietto").val();
        let dataFineBiglietto = $("#dataFineBiglietto").val();
        let idTipoBiglietto = $('#idTipoBiglietto').val();
        let orarioBiglietto = $("#orarioBiglietto").val();
        let prezzoBiglietto = $("#prezzoBiglietto").val();
        $.post(
            "utils/event-cart.php",
            {
                azione: "modificaBiglietto", idBiglietto: idBiglietto, idSezioneEvento: idSezioneEvento,
                dataInizioBiglietto: dataInizioBiglietto, dataFineBiglietto: dataFineBiglietto,
                idTipoBiglietto: idTipoBiglietto, orarioBiglietto: orarioBiglietto, prezzoBiglietto: prezzoBiglietto
            },
            function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok") {
                    window.setTimeout(function(){location.reload()},1500);
                }
            });

    });

    const fpFBiglietto = flatpickr("#dataFineBiglietto", {
        minDate: "today",
    });

    $("#dataInizioBiglietto").flatpickr({
        onChange: function(selectedDates, dateStr, instance) {
            fpFBiglietto.set("minDate", dateStr);
            fpFBiglietto.setDate(dateStr);
        },
        minDate: "today",
    });

    $("#idTipoBiglietto").select2({
        placeholder: "Seleziona un tipo"
    });
    
    $("#idSezioneEvento").select2({
        placeholder: "Seleziona una sezione"
    });

    $("#orarioBiglietto").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    //sezione model modificaSezione

    //sezione model modficaLuogo

    const nTickets = $("#nTickets").val();
    const nAbbonamenti = $("#nAbbonamenti").val();

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

    //apertura form modifica biglietto
    $(".editTicket").click(function(){
        let idBiglietto = $(this).val();
        $.post("utils/event-cart.php",
                {azione: "getInfoBiglietto", idBiglietto: idBiglietto},
                function(data){
                    let risposta = JSON.parse(data);
                    $("#idBigliettoModifica").val(idBiglietto);
                    $('#idSezioneEvento option[value=' + risposta.idSezioneEvento +']').prop('selected', 'selected').change();
                    $("#dataInizioBiglietto").val(risposta.dataInizio);
                    $("#dataFineBiglietto").val(risposta.dataFine);
                    $('#idTipoBiglietto option[value=' + risposta.idTipoBiglietto +']').prop('selected', 'selected').change();
                    $("#orarioBiglietto").val(risposta.orarioBiglietto);
                    $("#prezzoBiglietto").val(risposta.prezzoBiglietto);
                }
            );
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