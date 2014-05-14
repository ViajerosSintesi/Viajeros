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
          var pasa = 1;
          if(mail == ""){
                $("#emailLog").addClass("has-error");
                pasa = 0;
          }else if(pass == ""){
                $("#passLog").addClass("has-error");
                pasa = 0;
          }
          if(pasa){
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
          }
    });
    
	
	
	// juvenc
	function validar_email(valor)
	{
		// creamos nuestra regla con expresiones regulares.
		var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		// utilizamos test para comprobar si el parametro valor cumple la regla
		if(filter.test(valor))
			return true;
		else
			return false;
	}
	
    
	$("#mailReg").change(function(){
	if($("#mailReg").val() == '')
		{
			alert("Ingrese un email");
		}else if(validar_email($("#mailReg").val()))
		{
			alert("Email valido");
		}else
		{
			alert("El email no es valido");
		}
	});
	// juvenc
	
	
	
	
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
    
    
    $("#repeatPassReg").change(function(){
     if($(this).val() != $("#passReg").val()){
        $("#divrepPass").addClass("has-error");  
     }else{
         $("#divrepPass").removeClass("has-error");  
     }
    });
});