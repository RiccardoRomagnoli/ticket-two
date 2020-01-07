$(document).ready(function(){    
    //tabella artisti
    let tableArtisti = $('#tableRicercaArtisti').DataTable( {            
        ajax: {
            "url": "utils/search.php",
            "type": "POST",
            "data": {
                "testoRicerca": $("#testoRicerca").val(),
                "azione": "ricercaArtisti"
            }
        } 
    });
    $('#tableRicercaArtisti').on('click', 'tbody tr', function () {
        var row = tableArtisti.row($(this)).data();
        window.location = "./artist.php?id=" + row[0];
      });

    //tabella luoghi
    let tableLuoghi = $('#tableRicercaLuoghi').DataTable( {            
        ajax: {
            "url": "utils/search.php",
            "type": "POST",
            "data": {
                "testoRicerca": $("#testoRicerca").val(),
                "azione": "ricercaLuoghi"
            }
        } 
    });

    $('#tableRicercaLuoghi').on('click', 'tbody tr', function () {
        var row = tableLuoghi.row($(this)).data();
        window.location = "./place.php?id=" + row[0];
      });

    //tabella eventi
      let tableEventi = $('#tableRicercaEventi').DataTable( {            
        ajax: {
            "url": "utils/search.php",
            "type": "POST",
            "data": {
                "testoRicerca": $("#testoRicerca").val(),
                "azione": "ricercaEventi"
            }
        } 
    });
    $('#tableRicercaEventi').on('click', 'tbody tr', function () {
        var row = tableEventi.row($(this)).data();
        window.location = "./evento.php?idevento=" + row[0];
      });
});