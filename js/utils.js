$(document).ready(function(){
    //Get the button
    var toTopBtn = document.getElementById("toTop");
    
    //search reference
    $(".uk-search").submit(function(e) {
        e.preventDefault();
        let testoRicerca = $(".uk-search-input").val();
        if(testoRicerca.length != 0){
            window.location = "./search.php?ricerca=" + testoRicerca;
        }
    });

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        scrollFunction();
    };
    
    function scrollFunction() {
        if (document.body.scrollTop > 40 || document.documentElement.scrollTop > 40) {
            toTopBtn.style.display = "block";
        } else {
            toTopBtn.style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0;
        document.documentElement.scrollTop = 0;
    }
});


