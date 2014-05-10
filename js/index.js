$(document).ready(function(){
    $("#registro").hide();
    $("#registrarse").click(function(){
        $("#registro").show();
        $(".login").hide();
    });
    
    $("#btnRegistro").click(function(){
    var user = $("#usernameReg").val();
    var mail = $("#mailReg").val();
    var pass = $("#passReg").val();
    var rePass = $("#repeatPassReg").val();
    if(pass == rePass){
        $.ajax({
            type: "POST",
            url: "php/registro.php",
            data: {"user":user, "mail":mail,"pass":pass }
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