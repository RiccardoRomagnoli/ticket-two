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


    $(".uk-search-input").click(function(){

        console.log($(this).text());
    });

    //sezione model modifica evento

    $("#modificaEventoForm").submit(function(e) {
        e.preventDefault();
        let titolo = $("#nomeEvento").val();
        let dataInizio = $("#dataInizioModifica").val();
        let dataFine = $("#dataFineModifica").val();
        let descrizione = $("#descrizioneEvento").val();
        let myFile = $('#pathLocandina').prop('files')[0];
        let idLuogo = $("#idLuogo").val();
        let categorie = $("#idCategoria").val(); 
        let artisti =  $("#idArtista").val();
        let formData = new FormData();
        
        formData.append("azione", "modificaEvento");
        formData.append("idEvento", idEvent);
        formData.append("titolo", titolo);
        formData.append("dataInizio", dataInizio);
        formData.append("dataFine", dataFine);
        formData.append("descrizione", descrizione);
        formData.append("fotoLocation", myFile);
        formData.append("idLuogo", idLuogo);

        //delete categorie e artisti di un evento

        $.post("utils/event-cart.php",
        {idEvento: idEvent, azione: "cancellaCategorieEvento"},
        function(data){
        });

        $.post("utils/event-cart.php",
            {idEvento: idEvent, azione: "cancellaArtistiEvento"},
            function(data){
        });       

        //aggiungi per ogni categoria e artista delle let

        categorie.forEach(categoria => {
            $.post("utils/event-cart.php",
            {idEvento: idEvent, idCategoria: categoria, azione: "aggiungiCategoriaEvento"},
            function(data){
            });    
        }); 

        artisti.forEach(artista => {
            $.post("utils/event-cart.php",
            {idEvento: idEvent, idArtista: artista, azione: "aggiungiArtistaEvento"},
            function(data){
            });    
        });

        //modifica dei campi dell'evento
        $.ajax({
            url: 'utils/event-cart.php',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok") {
                    window.setTimeout(function(){location.reload()},1500);
                }
            }
        });

    });

    $("#idArtista").select2({
        placeholder: "Seleziona un artista",
        allowClear: true
    });

    $("#idCategoria").select2({
        placeholder: "Seleziona una categoria",
        allowClear: true
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
                    window.setTimeout(function(){location.reload();},1500);
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

    $('#idSezioneEvento').on('change', function (e) {
        let idSezione = $(this).val();
        $('.editSection').val(idSezione);
      });

    $('.editSection').click(function(){
        let idSezione = $(this).val();

        $.post("utils/event-cart.php",
                {azione: "getInfoSezione", idSezione: idSezione},
                function(data){
                    let risposta = JSON.parse(data);
                    $("#idSezioneModifica").val(risposta.idSezione);
                    $("#nomeSezione").val(risposta.nomeSezione);
                    $("#postiTotali").val(risposta.postiTotali);
                }
            );
    });

    $("#orarioBiglietto").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    $("#deleteBigliettoBtn").click(function(){
        let idBiglietto = $("#idBigliettoModifica").val();
        $.post(
            "utils/event-cart.php",
            {
                azione: "eliminaBiglietto", idBiglietto: idBiglietto
            },
            function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok"){
                    window.setTimeout(function(){location.reload()},1500);
                }
            });
    });

    //sezione model addLuogo

    $("#idAddProvincia").prop('disabled', true);
    $("#idAddCitta").prop('disabled', true);

    $("#idAddRegione").select2({
        placeholder: "Seleziona una regione"
    });

    $('#idAddRegione').on('change.select2', function (e) {
        let idRegione = $(this).val();
        $("#idAddProvincia").empty();
        $("#idAddCitta").empty();
        $("#idAddProvincia").prop('disabled', true);
        $("#idAddCitta").prop('disabled', true);
        $.post(
            "utils/event-cart.php",
            {
                azione: "getProvince", idRegione: idRegione
            },
            function(data){
                $("#idAddProvincia").append('<option> </option>');
                JSON.parse(data).forEach(provincia => {
                    $("#idAddProvincia").append('<option value="' + provincia.IdProvincia + '">' + provincia.Nome + '</option>');
                });
            });
            $("#idAddProvincia").prop('disabled', false);
    });
    
    $("#idAddProvincia").select2({
        placeholder: "Seleziona una provincia"
    });

    $('#idAddProvincia').on('change.select2', function (e) {
        let idProvincia = $(this).val();
        $("#idAddCitta").empty();
        $("#idAddCitta").prop('disabled', true);
        $.post(
            "utils/event-cart.php",
            {
                azione: "getCitta", idProvincia: idProvincia
            },
            function(data){
                $("#idAddProvincia").append('<option> </option>');
                JSON.parse(data).forEach(citta => {
                    $("#idAddCitta").append('<option value="' + citta.IdCitta + '">' + citta.Nome + '</option>');
                });
            });
            $("#idAddCitta").prop('disabled', false);
    });

    $("#apriModalAddLuogo").click(function(){
            $("#addLuogoForm")[0].reset();
            $("#idAddProvincia").empty();
            $("#idAddCitta").empty();
            $("#idAddProvincia").prop('disabled', true);
            $("#idAddCitta").prop('disabled', true);
        }
    );

    $("#idAddCitta").select2({
        placeholder: "Seleziona una citta"
    });

    $("#addLuogoForm").submit(function(e) {
        e.preventDefault();
        let nomeLuogo = $("#nomeAddLuogo").val();
        let descrizioneLuogo = $("#descrizioneAddLuogo").val();
        let idCitta = $("#idAddCitta").val();
        $.post(
            "utils/event-cart.php",
            {
                azione: "aggiungiLuogo", nomeLuogo: nomeLuogo,
                descrizioneLuogo: descrizioneLuogo, idCitta: idCitta
            },
            function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok") {
                    window.setTimeout(function(){
                    //post e ricarica valori nella option del model prima con empty e append
                    UIkit.modal($("#modal-addLuogo")).hide();
                    },1500);
                }
            });
    });

    //sezione model addBiglietto

    $("#addBigliettoForm").submit(function(e) {
        e.preventDefault();
        let idSezioneEvento = $("#idAddSezioneEvento").val();
        let dataInizioBiglietto = $("#dataAddInizioBiglietto").val();
        let dataFineBiglietto = $("#dataAddFineBiglietto").val();
        let idTipoBiglietto = $('#idAddTipoBiglietto').val();
        let orarioBiglietto = $("#orarioAddBiglietto").val();
        let prezzoBiglietto = $("#prezzoAddBiglietto").val();
        $.post(
            "utils/event-cart.php",
            {
                azione: "aggiungiBiglietto", idSezioneEvento: idSezioneEvento,
                dataInizioBiglietto: dataInizioBiglietto, dataFineBiglietto: dataFineBiglietto,
                idTipoBiglietto: idTipoBiglietto, orarioBiglietto: orarioBiglietto, prezzoBiglietto: prezzoBiglietto
            },
            function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok") {
                    window.setTimeout(function(){location.reload();},1500);
                }
            });
    });

    const fpABiglietto = flatpickr("#dataAddFineBiglietto", {
        minDate: "today",
    });

    $('.editAddSection').click(function(){
        let idSezione = $(this).val();

        $.post("utils/event-cart.php",
                {azione: "getInfoSezione", idSezione: idSezione},
                function(data){
                    let risposta = JSON.parse(data);
                    $("#idSezioneModifica").val(risposta.idSezione);
                    $("#nomeSezione").val(risposta.nomeSezione);
                    $("#postiTotali").val(risposta.postiTotali);
                }
            );
    });

    $("#dataAddInizioBiglietto").flatpickr({
        onChange: function(selectedDates, dateStr, instance) {
            fpABiglietto.set("minDate", dateStr);
            fpABiglietto.setDate(dateStr);
        },
        minDate: "today",
    });

    $("#idAddTipoBiglietto").select2({
        placeholder: "Seleziona un tipo"
    });
    
    $("#idAddSezioneEvento").select2({
        placeholder: "Seleziona una sezione"
    });

    $('#idAddSezioneEvento').on('change', function (e) {
        let idSezione = $(this).val();
        $('.editAddSection').val(idSezione);
      });

    $("#orarioAddBiglietto").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });


    //sezione model modificaSezione

    $("#modificaSezioneForm").submit(function(e) {
        e.preventDefault();
        let idSezione = $("#idSezioneModifica").val();
        let nomeSezione = $("#nomeSezione").val();
        let postiTotali = $("#postiTotali").val();

        $.post(
            "utils/event-cart.php",
            {
                azione: "modificaSezione", idSezione: idSezione, nomeSezione: nomeSezione,
                postiTotali: postiTotali
            },
            function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok") {
                    window.setTimeout(function(){UIkit.modal($("#modal-editSection")).hide();},1500);
                }
            });
    });

    //sezione model addSezione

    $("#addSezioneForm").submit(function(e) {
        e.preventDefault();
        let nomeSezione = $("#nomeSezioneAdd").val();
        let postiTotali = $("#postiTotaliAdd").val();

        $.post(
            "utils/event-cart.php",
            {
                azione: "aggiungiSezione", idEvento: idEvent, nomeSezione: nomeSezione,
                postiTotali: postiTotali
            },
            function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok") {
                    window.setTimeout(function(){
                        //aggiornamento con post della select delle sezioni 
                        UIkit.modal($("#modal-addSection")).hide();},1500);
                }
            });
    });
    
    $("#addSection").click(function(){
        $("#addSezioneForm")[0].reset();
    });

    //bottone acquisto ticket

    $(".aggiungiTicket").click(function(){
        let idBiglietto = $(this).val();
        let nTicket = $("#numeroTicket" + idBiglietto).val();
        
        //carrello non esiste creo riga sul db
        $.post("utils/event-cart.php",
            {azione: "creaCart"},
            function(data){
                idCart = data;
                //aggiungo righe al carrello in base alla quantità
                for(let c=0; c<nTicket; c++){
                    $.post("utils/event-cart.php",
                        {idCart: idCart, idBiglietto: idBiglietto, azione: "acquistoBiglietto"},
                        function(data){checkEvento(JSON.parse(data));}
                    );
                }
            }
        );
    });  

    //bottone apertura modal modifica evento
    $("#openModalEditEvent").click(function(){
        //pulisci le select
        $("#idArtista").prop("disabled", true);
        $("#idCategoria").prop("disabled", true);
        $("#idArtista").empty();
        $("#idCategoria").empty();

        //riempi gli artisti scelti prima
        $.post("utils/event-cart.php",
                {azione: "getArtistiEvento", idEvento: idEvent},
                 function(data){
                    var c = document.createDocumentFragment();
                    JSON.parse(data).forEach(artista => {
                            var e = document.createElement("option");
                            e.selected = true;
                            e.value = artista.IdArtista;
                            e.text = artista.Nome;
                            c.appendChild(e);
                        });
                    $("#idArtista").append(c);
                }
            );
            
        //riempi gli artisti non scelti
        $.post("utils/event-cart.php",
                {azione: "getArtistiNonEvento", idEvento: idEvent},
                 function(data){
                    var c = document.createDocumentFragment();
                    JSON.parse(data).forEach(artista => {
                            var e = document.createElement("option");
                            e.value = artista.IdArtista;
                            e.text = artista.Nome;
                            c.appendChild(e);
                        });
                    $("#idArtista").append(c);
                }
            );

        //riempi le categorie scelte prima
        $.post("utils/event-cart.php",
            {azione: "getCategorieEvento", idEvento: idEvent},
             function(data){
                var c = document.createDocumentFragment();
                JSON.parse(data).forEach(artista => {
                        var e = document.createElement("option");
                        e.selected = true;
                        e.value = artista.IdCategoria;
                        e.text = artista.Nome;
                        c.appendChild(e);
                    });
                $("#idCategoria").append(c);
            }
        );

        //riempi le categorie non scelte
        $.post("utils/event-cart.php",
        {azione: "getCategorieNonEvento", idEvento: idEvent},
         function(data){
            var c = document.createDocumentFragment();
                JSON.parse(data).forEach(artista => {
                    var e = document.createElement("option");
                    e.value = artista.IdCategoria;
                    e.text = artista.Nome;
                    c.appendChild(e);
                });
                $("#idCategoria").append(c);
            }
        );

        $("#idArtista").prop("disabled", false);
        $("#idCategoria").prop("disabled", false);
    });

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