$(document).ready(function(){
    //Get the button
    var toTopBtn = document.getElementById("toTop");
    

    // When the user scrolls down 20px from the top of the document, show the button
    window.onscroll = function() {
        scrollFunction();
    };

    $("#loginBtn").click(function(){
        if( $("#loginLegend").text() == "Login"){
            var mail  = $("#mail").val();
            var password  = $("#password").val();

            $.post("utils/login.php",
                {mail: mail, password: password},
                function(data, status){checkLoginResult(JSON.parse(data));});
        }else{
            $("#loginLegend").text("Login");
            $("#nameDiv").attr("hidden", true);
            $("#surnameDiv").attr("hidden", true);
            $("#passwordRipDiv").attr("hidden", true);
            $("#loginBtn").removeClass("uk-button-primary");
            $("#loginBtn").addClass("uk-button-default");
            $("#singupBtn").removeClass("uk-button-default");
            $("#singupBtn").addClass("uk-button-primary");
        }
    });

    $("#singupBtn").click(function(){
        if( $("#loginLegend").text() == "Registrazione" ){
            var name  = $("#name").val();
            var surname  = $("#surname").val();
            var mail  = $("#mail").val();
            var password  = $("#password").val();
            var passwordRip  = $("#passwordRip").val();

            $.post("utils/singup.php",
                {mail: mail, name:name, surname:surname, passwordRip:passwordRip, password: password},
                function(data, status){console.log(data); checkSingupResult(JSON.parse(data));});
        }else{
            $("#loginLegend").text("Registrazione");
            $("#nameDiv").removeAttr("hidden");
            $("#surnameDiv").removeAttr("hidden");
            $("#passwordRipDiv").removeAttr("hidden");
            $("#singupBtn").removeClass("uk-button-primary");
            $("#singupBtn").addClass("uk-button-default");
            $("#loginBtn").removeClass("uk-button-default");
            $("#loginBtn").addClass("uk-button-primary");
        }
    });

    function checkLoginResult(response){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
            });
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

    function checkSingupResult(response){
        if(response.result == "ok"){
            UIkit.notification({
                message: '<span uk-icon="icon: check"></span> '+response.message,
                status: 'success',
                pos: 'top-right'
            });
            window.setTimeout(function(){location.reload()},1000);
        }else if(response.result == "warning"){
            UIkit.notification({
                message: '<span uk-icon="icon: close"></span> '+response.message,
                status: 'warning',
                pos: 'top-right',
                timeout: 2500
            });
        }else {
            UIkit.notification({
                message: '<span uk-icon="icon: close"></span> '+response.message,
                status: 'danger',
                pos: 'top-right',
                timeout: 2500
            });
        }
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


