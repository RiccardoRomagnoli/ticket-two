$(document).ready(function(){
    //Get the button
    var toTopBtn = document.getElementById("toTop");
    

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        scrollFunction();
    };

    $("#loginBtn").click(function(){
        var username  = $("#mail").val();
        var password  = $("#password").val();
        console.log(username);
        $.post("utils/login.php",
               {username: username, password: password},
               function(data, status){ checkLoginResult(data);});
    });

    $("#singupBtn").click(function(){
        window.alert("registrazione");
    });

    function checkLoginResult(response){
        console.log(response);
    }

    function checkSingupResult(response){
        console.log(response);
    }

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


