$(document).ready(function(){
    $("#registro").hide();
    $("#registrarse").click(function(){
        $("#registro").show();
        $("#login").hide();
        $("#registrarse").hide();
    });
    
    $("#btnLogin").click(function(){
          var mail = $("#emailLog").val();
          var pass = $("#passLog").val();
          
        $.ajax({
            type: "POST",
            url: "php/controlLogin.php",
            data: {"mail":mail,"pass":pass, "login":1}
        })
        .done(function(data){
                var not = $.parseJSON(data);
             if(!not.notice){
                 alert("no te has logueado");
             }
             if(not.notice == 1){
                   alert("Has entrado");
             }
             if(not.notice == 2){
                   alert("no has activado la cuenta, mira en tu email");
             }
        });
    });
    
    
    $("#btnRegistro").click(function(){
    var user = $("#usernameReg").val();
    var mail = $("#mailReg").val();
    var pass = $("#passReg").val();
    var rePass = $("#repeatPassReg").val();
    if(pass == rePass){
        $.ajax({
            type: "POST",
            url: "php/controlRegistro.php",
            data: {"user":user, "mail":mail,"pass":pass }
        })
        .done(function(data){
              var not = $.parseJSON(data);
             if(!not.notice){
                 alert("no ha podido registrarse, prueva con otro email");
             }else{
                   alert("Enhorabuena! Mira en tu correo y activalo!");
             }
        });
    }else{
        alert("error repite contraseña");
    }
    });
    
    /*no funciona*/
    $("#repeatPassReg").change(function(){
     if($(this).val() != $("#passReg").val()){
        $("#divrepPass").addClass("has-error");  
     }else{
         $("#divrepPass").removeClass("has-error");  
     }
    });
});