$(document).ready(function(){

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
            $("#radio").attr("hidden", true);
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
            var radio = $("input[name='radio']:checked").val();

            $.post("utils/singup.php",
                {mail: mail, name:name, surname:surname, passwordRip:passwordRip, password: password, radio:radio},
                function(data, status){checkSingupResult( JSON.parse(data));});
        }else{
            $("#loginLegend").text("Registrazione");
            $("#nameDiv").removeAttr("hidden");
            $("#surnameDiv").removeAttr("hidden");
            $("#passwordRipDiv").removeAttr("hidden");
            $("#radio").removeAttr("hidden");
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
});