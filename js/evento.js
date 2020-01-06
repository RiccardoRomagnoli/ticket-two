$(document).ready(function(){

    const idEvento = $("#idEvento").val();
    
    //flatpickr data configurazione
    let fpInizio = flatpickr(".dataInizio", {
        minDate: "today"
    });

    let fpFine = flatpickr(".dataFine", {
        minDate: "today"
    });

    if(Array.isArray(fpInizio)){
        for (let index = 0; index < fpInizio.length; index++) {
            fpInizio[index].set("onChange", function(selectedDates, dateStr, instance) {
                fpFine[index].set("minDate", dateStr);
                fpFine[index].setDate(dateStr);
            });
        }
    } else {
            fpInizio.set("onChange", function(selectedDates, dateStr, instance) {
                fpFine.set("minDate", dateStr);
                fpFine.setDate(dateStr);
            });
    }

    //classi oggetti comuni
    $(".selectRegione").select2({
        placeholder: "Seleziona una regione"
    });

    $(".selectProvincia").select2({
        placeholder: "Seleziona una provincia"
    });

    $(".selectCitta").select2({
        placeholder: "Seleziona una citta"
    });

    $(".selectTipoBiglietto").select2({
        placeholder: "Seleziona un tipo"
    });
    
    $(".selectSezioneEvento").select2({
        placeholder: "Seleziona una sezione"
    });

    $(".selectArtista").select2({
        placeholder: "Seleziona un artista",
        allowClear: true
    });

    $(".selectCategoria").select2({
        placeholder: "Seleziona una categoria",
        allowClear: true
    });

    $(".selectLuogo").select2({
        placeholder: "Seleziona un luogo"
    });

    $(".orarioBiglietto").flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    //bottone follow/unfollow
    $("#followBtn").click(function(){
        if( $("#followBtn").text() == "Segui"){
             $.post("utils/follow-event.php",
                 {idEvento: idEvento, follow: "true"},
                 function(data){
                    checkEvento(JSON.parse(data));
                    if(JSON.parse(data).result == "ok"){
                        $("#followBtn").text("Non seguire più");
                    }
                    });
        } else {
            $.post("utils/follow-event.php",
                {idEvento: idEvento, follow: "false"},
                function(data){
                    checkEvento(JSON.parse(data));
                    if(JSON.parse(data).result == "ok") {
                        $("#followBtn").text("Segui");
                    }
                });
        }
    });

    //pulsanti id specifici

    $('#addSelectIdRegione').on('change.select2', function (e) {
        let idRegione = $(this).val();
        $("#addSelectIdProvincia").empty();
        $("#addSelectIdCitta").empty();
        $("#addSelectIdProvincia").prop('disabled', true);
        $("#addSelectIdCitta").prop('disabled', true);
        $.post(
            "utils/event-cart.php",
            {
                azione: "getProvince", idRegione: idRegione
            },
            function(data){
                $("#addSelectIdProvincia").append('<option> </option>');
                JSON.parse(data).forEach(provincia => {
                    $("#addSelectIdProvincia").append('<option value="' + provincia.IdProvincia + '">' + provincia.Nome + '</option>');
                });
            });
            $("#addSelectIdProvincia").prop('disabled', false);
    });

    $('#addSelectIdProvincia').on('change.select2', function (e) {
        let idProvincia = $(this).val();
        $("#addSelectIdCitta").empty();
        $("#addSelectIdCitta").prop('disabled', true);
        $.post(
            "utils/event-cart.php",
            {
                azione: "getCitta", idProvincia: idProvincia
            },
            function(data){
                $("#addSelectIdCitta").append('<option> </option>');
                JSON.parse(data).forEach(citta => {
                    $("#addSelectIdCitta").append('<option value="' + citta.IdCitta + '">' + citta.Nome + '</option>');
                });
            });
            $("#addSelectIdCitta").prop('disabled', false);
    });

    //pulsanti apertura modal e form 
    $(".openModalAddSection").click(function(){
        $("#addSezioneForm")[0].reset();
    });
    
    $(".openModalAddArtista").click(function(){
        $("#addArtistaForm")[0].reset();
    });
    
    $(".openModalAddLuogo").click(function(){
        $("#addLuogoForm")[0].reset();
        $("#addSelectIdRegione").empty();
        $("#addSelectIdProvincia").empty();
        $("#addSelectIdCitta").empty();
        $("#addSelectIdRegioni").prop('disabled', true);
        $("#addSelectIdProvincia").prop('disabled', true);
        $("#addSelectIdCitta").prop('disabled', true);

        //TODO: fill regioni con post addSelectIdRegioni e attivala
        $.post("utils/event-cart.php",
                {azione: "getRegioni"},
                function(data){
                    $("#addSelectIdRegione").append('<option></option>');
                    JSON.parse(data).forEach(regione => {
                        $("#addSelectIdRegione").append('<option value="' + regione.IdRegione + '">' + regione.Nome + '</option>');
                    });
                });
                $("#addSelectIdRegione").prop('disabled', false);
    });

    $(".openModalEditTicket").click(function(){
        let idBiglietto = $(this).val();
        $("#editBigliettoForm")[0].reset();
        $("#editSelectIdSezioneEvento").empty();
        $("#editSelectIdTipoBiglietto").empty();
        $("#editSelectIdSezioneEvento").prop('disabled', true);
        $("#editSelectIdTipoBiglietto").prop('disabled', true);

        //riempi la sezione scelta prima
        $.post("utils/event-cart.php",
                {azione: "getSezioneBiglietto", idBiglietto: idBiglietto},
                 function(data){
                    var c = document.createDocumentFragment();
                    JSON.parse(data).forEach(sezione => {
                            var e = document.createElement("option");
                            e.selected = true;
                            e.value = sezione.IdSezione;
                            e.text = sezione.Nome;
                            c.appendChild(e);
                        });
                    $("#editSelectIdSezioneEvento").append(c);
                }
            );
            
        //riempi le altre sezioni non scelte
        $.post("utils/event-cart.php",
                {azione: "getSezioneNonBiglietto", idBiglietto: idBiglietto},
                 function(data){
                    var c = document.createDocumentFragment();
                    JSON.parse(data).forEach(sezione => {
                            var e = document.createElement("option");
                            e.value = sezione.IdSezione;
                            e.text = sezione.Nome;
                            c.appendChild(e);
                        });
                    $("#editSelectIdSezioneEvento").append(c);
                }
            );


        //riempi il tipo di biglietto scelti
        $.post("utils/event-cart.php",
                {azione: "getTipoBigliettoBiglietto", idBiglietto: idBiglietto},
                 function(data){
                    var c = document.createDocumentFragment();
                    JSON.parse(data).forEach(tipoBiglietto => {
                            var e = document.createElement("option");
                            e.selected = true;
                            e.value = tipoBiglietto.IdTipoBiglietto;
                            e.text = tipoBiglietto.Nome;
                            c.appendChild(e);
                        });
                    $("#editSelectIdTipoBiglietto").append(c);
                }
            );
            
        //riempi i tipi di biglietto non scelti
        $.post("utils/event-cart.php",
                {azione: "getTipoBigliettoNonBiglietto", idBiglietto: idBiglietto},
                 function(data){
                    var c = document.createDocumentFragment();
                    JSON.parse(data).forEach(tipoBiglietto => {
                            var e = document.createElement("option");
                            e.value = tipoBiglietto.IdTipoBiglietto;
                            e.text = tipoBiglietto.Nome;
                            c.appendChild(e);
                        });
                    $("#editSelectIdTipoBiglietto").append(c);
                }
            );
        //riempi resto dei campi
        $.post("utils/event-cart.php",
                {azione: "getInfoBiglietto", idBiglietto: idBiglietto},
                function(data){
                    let risposta = JSON.parse(data);
                    $("#editIdBiglietto").val(idBiglietto);
                    $("#editDataInizioBiglietto").val(risposta.dataInizio);
                    $("#editDataFineBiglietto").val(risposta.dataFine);
                    $("#editOrarioBiglietto").val(risposta.orarioBiglietto);
                    $("#editPrezzoBiglietto").val(risposta.prezzoBiglietto);
                }
            );
        $("#editSelectIdSezioneEvento").prop('disabled', false);
        $("#editSelectIdTipoBiglietto").prop('disabled', false);
    });

    $("#openModalEditEvent").click(function(){
        $("#editEventoForm")[0].reset();

        $.post("utils/event-cart.php",
                {azione: "getInfoEvento", idEvento: idEvento},
                 function(data){
                    //fill i campi della model
                    let risposta = JSON.parse(data);
                    $("#editNomeEvento").val(risposta.nomeEvento);
                    $("#editDataInizio").val(risposta.dataInizioEvento);
                    $("#editDataFine").val(risposta.dataFineEvento);
                    $("#editDescrizioneEvento").text(risposta.descrizioneEvento);
                }
            );

        $("#editSelectIdArtista").prop("disabled", true);
        $("#editSelectIdCategoria").prop("disabled", true);
        $("#editSelectIdLuogo").prop("disabled", true);
        $("#editSelectIdArtista").empty();
        $("#editSelectIdCategoria").empty();
        $("#editSelectIdLuogo").empty();

        //riempi il luoghi scelto prima
        $.post("utils/event-cart.php",
                {azione: "getLuogoEvento", idEvento: idEvento},
                 function(data){
                    var c = document.createDocumentFragment();
                    JSON.parse(data).forEach(luogo => {
                            var e = document.createElement("option");
                            e.selected = true;
                            e.value = luogo.IdLuogo;
                            e.text = luogo.Nome;
                            c.appendChild(e);
                        });
                    $("#editSelectIdLuogo").append(c);
                }
            );
            
        //riempi gli altri luoghi non scelti
        $.post("utils/event-cart.php",
                {azione: "getLuoghiNonEvento", idEvento: idEvento},
                 function(data){
                    var c = document.createDocumentFragment();
                    JSON.parse(data).forEach(luogo => {
                            var e = document.createElement("option");
                            e.value = luogo.IdLuogo;
                            e.text = luogo.Nome;
                            c.appendChild(e);
                        });
                    $("#editSelectIdLuogo").append(c);
                }
            );


        //riempi gli artisti scelti prima
        $.post("utils/event-cart.php",
                {azione: "getArtistiEvento", idEvento: idEvento},
                 function(data){
                    var c = document.createDocumentFragment();
                    JSON.parse(data).forEach(artista => {
                            var e = document.createElement("option");
                            e.selected = true;
                            e.value = artista.IdArtista;
                            e.text = artista.Nome;
                            c.appendChild(e);
                        });
                    $("#editSelectIdArtista").append(c);
                }
            );
            
        //riempi gli artisti non scelti
        $.post("utils/event-cart.php",
                {azione: "getArtistiNonEvento", idEvento: idEvento},
                 function(data){
                    var c = document.createDocumentFragment();
                    JSON.parse(data).forEach(artista => {
                            var e = document.createElement("option");
                            e.value = artista.IdArtista;
                            e.text = artista.Nome;
                            c.appendChild(e);
                        });
                    $("#editSelectIdArtista").append(c);
                }
            );

        //riempi le categorie scelte prima
        $.post("utils/event-cart.php",
            {azione: "getCategorieEvento", idEvento: idEvento},
             function(data){
                var c = document.createDocumentFragment();
                JSON.parse(data).forEach(artista => {
                        var e = document.createElement("option");
                        e.selected = true;
                        e.value = artista.IdCategoria;
                        e.text = artista.Nome;
                        c.appendChild(e);
                    });
                $("#editSelectIdCategoria").append(c);
            }
        );

        //riempi le categorie non scelte
        $.post("utils/event-cart.php",
        {azione: "getCategorieNonEvento", idEvento: idEvento},
         function(data){
            var c = document.createDocumentFragment();
                JSON.parse(data).forEach(artista => {
                    var e = document.createElement("option");
                    e.value = artista.IdCategoria;
                    e.text = artista.Nome;
                    c.appendChild(e);
                });
                $("#editSelectIdCategoria").append(c);
            }
        );

        $("#editSelectIdArtista").prop("disabled", false);
        $("#editSelectIdCategoria").prop("disabled", false);
        $("#editSelectIdLuogo").prop("disabled", false);
    });

    $('#openModalEditSectionInAddBiglietto').click(function(){
        $("#editSezioneForm")[0].reset();
        let idSezione = $('#addSelectIdSezioneEvento').val();

        $.post("utils/event-cart.php",
                {azione: "getInfoSezione", idSezione: idSezione},
                function(data){
                    let risposta = JSON.parse(data);
                    $("#editIdSezione").val(risposta.idSezione);
                    $("#editNomeSezione").val(risposta.nomeSezione);
                    $("#editPostiTotali").val(risposta.postiTotali);
                }
            );
    });

    $('#openModalEditSectionInEditBiglietto').click(function(){
        $("#editSezioneForm")[0].reset();

        let idSezione = $('#editSelectIdSezioneEvento').val();

        $.post("utils/event-cart.php",
                {azione: "getInfoSezione", idSezione: idSezione},
                function(data){
                    let risposta = JSON.parse(data);
                    $("#editIdSezione").val(risposta.idSezione);
                    $("#editNomeSezione").val(risposta.nomeSezione);
                    $("#editPostiTotali").val(risposta.postiTotali);
                }
            );
    });

    $('.openModalAddTicket').click(function(){
        $("#addBigliettoForm")[0].reset();

        $("#addSelectIdSezioneEvento").prop("disabled", true);
        $("#addSelectIdTipoBiglietto").prop("disabled", true);
        $("#addSelectIdSezioneEvento").empty();
        $("#addSelectIdTipoBiglietto").empty();

        //riempi le sezioni dell'evento
        $.post("utils/event-cart.php",
                {azione: "getSezioniEvento", idEvento: idEvento},
                 function(data){
                    var c = document.createDocumentFragment();
                    JSON.parse(data).forEach(sezione => {
                            var e = document.createElement("option");
                            e.value = sezione.IdSezione;
                            e.text = sezione.Nome;
                            c.appendChild(e);
                        });
                    $("#addSelectIdSezioneEvento").append(c);
                }
            );
 
        //riempi i tipi di biglietto
        $.post("utils/event-cart.php",
                {azione: "getTipiBiglietto"},
                 function(data){
                    var c = document.createDocumentFragment();
                    JSON.parse(data).forEach(tipoBiglietto => {
                            var e = document.createElement("option");
                            e.value = tipoBiglietto.IdTipoBiglietto;
                            e.text = tipoBiglietto.Nome;
                            c.appendChild(e);
                        });
                    $("#addSelectIdTipoBiglietto").append(c);
                }
            );
        $("#addSelectIdSezioneEvento").prop("disabled", false);
        $("#addSelectIdTipoBiglietto").prop("disabled", false);
    });

    //submit forms
    $("#addEventoForm").submit(function(e) {
        e.preventDefault();
        let titolo = $("#addNomeEvento").val();
        let dataInizio = $("#addDataInizio").val();
        let dataFine = $("#addDataFine").val();
        let descrizione = $("#addDescrizioneEvento").val();
        let myFile = $('#addPathLocandina').prop('files')[0];
        let idLuogo = $("#addSelectIdLuogo").val();
        let categorie = $("#addSelectIdCategoria").val(); 
        let artisti =  $("#addSelectIdArtista").val();
        let formData = new FormData();
        
        formData.append("azione", "aggiungiEvento");
        formData.append("titolo", titolo);
        formData.append("dataInizio", dataInizio);
        formData.append("dataFine", dataFine);
        formData.append("descrizione", descrizione);
        formData.append("fotoLocation", myFile);
        formData.append("idLuogo", idLuogo);

        //aggiunta dei campi dell'evento
        $.ajax({
            url: 'utils/event-cart.php',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok") {
                    //aggiungi per ogni categoria delle select
                    categorie.forEach(categoria => {
                        $.post("utils/event-cart.php",
                        {idEvento: JSON.parse(data).idEvento, idCategoria: categoria, azione: "aggiungiCategoriaEvento"},
                        function(data){
                        });    
                    }); 

                    //aggiungi per ogni artista delle select
                    artisti.forEach(artista => {
                        $.post("utils/event-cart.php",
                        {idEvento: JSON.parse(data).idEvento, idArtista: artista, azione: "aggiungiArtistaEvento"},
                        function(data){
                        });    
                    });
                    window.setTimeout(function(){window.location = "./evento.php?idevento=" + JSON.parse(data).idEvento;}, 1500);
                }
            }
        });
    });

    $("#editBigliettoForm").submit(function(e) {
        e.preventDefault();
        let idBiglietto = $("#editIdBiglietto").val();
        let idSezioneEvento = $("#editSelectIdSezioneEvento").val();
        let dataInizioBiglietto = $("#editDataInizioBiglietto").val();
        let dataFineBiglietto = $("#editDataFineBiglietto").val();
        let idTipoBiglietto = $('#editSelectIdTipoBiglietto').val();
        let orarioBiglietto = $("#editOrarioBiglietto").val();
        let prezzoBiglietto = $("#editPrezzoBiglietto").val();
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

    $("#addLuogoForm").submit(function(e) {
        e.preventDefault();
        let nomeLuogo = $("#addNomeLuogo").val();
        let descrizioneLuogo = $("#addDescrizioneLuogo").val();
        let idCitta = $("#addSelectIdCitta").val();
        $.post(
            "utils/event-cart.php",
            {
                azione: "aggiungiLuogo", nomeLuogo: nomeLuogo,
                descrizioneLuogo: descrizioneLuogo, idCitta: idCitta
            },
            function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok") {
                    window.setTimeout(function(){UIkit.modal($("#modal-addLuogo")).hide();},1500);
                    $(".selectLuogo").each(function(i,obj){
                        obj.append(new Option(JSON.parse(data).nomeLuogo, JSON.parse(data).idLuogo));
                    });
                }
            });
    });

    $("#addBigliettoForm").submit(function(e) {
        e.preventDefault();
        let idSezioneEvento = $("#addSelectIdSezioneEvento").val();
        let dataInizioBiglietto = $("#addDataInizioBiglietto").val();
        let dataFineBiglietto = $("#addDataFineBiglietto").val();
        let idTipoBiglietto = $('#addSelectIdTipoBiglietto').val();
        let orarioBiglietto = $("#addOrarioBiglietto").val();
        let prezzoBiglietto = $("#addPrezzoBiglietto").val();
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

    $("#editSezioneForm").submit(function(e) {
        e.preventDefault();
        let idSezione = $("#editIdSezione").val();
        let nomeSezione = $("#editNomeSezione").val();
        let postiTotali = $("#editPostiTotali").val();

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

    $("#addSezioneForm").submit(function(e) {
        e.preventDefault();
        let nomeSezione = $("#addNomeSezione").val();
        let postiTotali = $("#addPostiTotali").val();

        $.post(
            "utils/event-cart.php",
            {
                azione: "aggiungiSezione", idEvento: idEvento, nomeSezione: nomeSezione,
                postiTotali: postiTotali
            },
            function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok") {
                    window.setTimeout(function(){
                        //aggiornamento con post della select delle sezioni 
                        UIkit.modal($("#modal-addSection")).hide();},1500);
                        $(".selectSezioneEvento").each(function(i,obj){
                            obj.append(new Option(JSON.parse(data).nomeSezione, JSON.parse(data).idSezione));
                        });
                }
            });
    });

    $("#addArtistaForm").submit(function(e) {
        e.preventDefault();
        let nomeArtista = $("#addNomeArtista").val();
        let descrizioneArtista = $("#addDescrizioneArtista").val();
        let myFile = $('#addPathArtista').prop('files')[0];
        let formData = new FormData();
        
        formData.append("azione", "aggiungiArtista");
        formData.append("nomeArtista", nomeArtista);
        formData.append("descrizioneArtista", descrizioneArtista);
        formData.append("fotoArtista", myFile);

        $.ajax({
            url: 'utils/event-cart.php',
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok") {
                    window.setTimeout(function(){
                        UIkit.modal($("#modal-addArtista")).hide();},1500);
                        $(".selectArtista").each(function(i,obj){
                            obj.append(new Option(JSON.parse(data).nomeArtista, JSON.parse(data).idArtista));
                        });
                }
            }
        });
    });

    $("#editEventoForm").submit(function(e) {
        e.preventDefault();
        let titolo = $("#editNomeEvento").val();
        let dataInizio = $("#editDataInizio").val();
        let dataFine = $("#editDataFine").val();
        let descrizione = $("#editDescrizioneEvento").val();
        let myFile = $('#editPathLocandina').prop('files')[0];
        let idLuogo = $("#editSelectIdLuogo").val();
        let categorie = $("#editSelectIdCategoria").val(); 
        let artisti =  $("#editSelectIdArtista").val();
        let formData = new FormData();
        
        formData.append("azione", "modificaEvento");
        formData.append("idEvento", idEvento);
        formData.append("titolo", titolo);
        formData.append("dataInizio", dataInizio);
        formData.append("dataFine", dataFine);
        formData.append("descrizione", descrizione);
        formData.append("fotoLocation", myFile);
        formData.append("idLuogo", idLuogo);

        //delete categorie e artisti di un evento

        $.post("utils/event-cart.php",
        {idEvento: idEvento, azione: "cancellaCategorieEvento"},
        function(data){
            categorie.forEach(categoria => {
                //aggiungi per ogni categoria delle select
                $.post("utils/event-cart.php",
                {idEvento: idEvento, idCategoria: categoria, azione: "aggiungiCategoriaEvento"},
                function(data){
                });    
            }); 
        });

        $.post("utils/event-cart.php",
            {idEvento: idEvento, azione: "cancellaArtistiEvento"},
            function(data){
                //aggiungi per ogni artista delle select
                artisti.forEach(artista => {
                    $.post("utils/event-cart.php",
                    {idEvento: idEvento, idArtista: artista, azione: "aggiungiArtistaEvento"},
                    function(data){
                    });    
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

    //delete form
    $("#deleteEventoBtn").click(function(){
        $.post(
            "utils/event-cart.php",
            {
                azione: "eliminaEvento", idEvento: idEvento
            },
            function(data){
                checkEvento(JSON.parse(data));
                if(JSON.parse(data).result == "ok"){
                    window.setTimeout(function(){location.reload()},1500);
                }
            });
    });

    $("#deleteBigliettoBtn").click(function(){
        let idBiglietto = $("#editIdBiglietto").val();
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

    //riempimento combobox per pagina aggiungi evento
    if($('#addEventoForm').length){
        //pulisci le select
        $("#addSelectIdArtista").prop("disabled", true);
        $("#addSelectIdCategoria").prop("disabled", true);
        $("#addSelectIdArtista").empty();
        $("#addSelectIdCategoria").empty();
            
        //riempi gli artisti non scelti
        $.post("utils/event-cart.php",
                {azione: "getArtistiNonEvento", idEvento: 0},
                 function(data){
                    var c = document.createDocumentFragment();
                    JSON.parse(data).forEach(artista => {
                            var e = document.createElement("option");
                            e.value = artista.IdArtista;
                            e.text = artista.Nome;
                            c.appendChild(e);
                        });
                    $("#addSelectIdArtista").append(c);
                }
            );

        //riempi le categorie non scelte
        $.post("utils/event-cart.php",
        {azione: "getCategorieNonEvento", idEvento: 0},
         function(data){
            var c = document.createDocumentFragment();
                JSON.parse(data).forEach(artista => {
                    var e = document.createElement("option");
                    e.value = artista.IdCategoria;
                    e.text = artista.Nome;
                    c.appendChild(e);
                });
                $("#addSelectIdCategoria").append(c);
            }
        );

        $("#addSelectIdArtista").prop("disabled", false);
        $("#addSelectIdCategoria").prop("disabled", false);
    }

    //bottone acquisto ticket
    $(".buyTicket").click(function(){
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