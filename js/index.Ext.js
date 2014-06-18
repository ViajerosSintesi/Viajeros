$(document).ready(function(){
	// texto en los inputs
	var valor="";
	$(".text-input").focus(function(){
		valor = $(this).val();
		if($(this).val()){
			$(this).val("");
		}else{
			$(this).val(valor);
		}
	})
	$(".text-input").focusout(function(){
		if($(this).val()==""){
			$(this).val(valor);
		}
	});
	// fin
	
	$("#genCaptchaB").click(function(){
	      $("#genCaptcha").html("<img src='php/controles/creaCaptcha.php?"+(new Date()).getTime()+"'/><input type='text' id='code'/>");
	});
	// validacion de contraseña_inicio
	$("#usuario").change(nombre_inicio);
	
	// validacion de contraseña_inicio
	$("#password").change(contrasenya_inicio);

	// validacion de contraseña_registro
	$("#contra").change(contrasenya_registro);
	
	// validacion de nombre_registro
	$("#nombre").change(nombre_registro);
	
	// validacion de apellido_registro
	$("#apellidos").change(apellido_registro);
	
	
	// validacion de gmail_registro instantaneo
	$("#email").change(email_registro);
	
	// validacion de fecha
	$("#dia").change(dia_registro);
	
	// validacion de fecha
	$("#mes").change(mes_registro);
	
	// validacion de fecha
	$("#any").change(any_registro);
	


    $("#form-registro").hide();
    $("#registro").click(function(){
        $("#form-login").hide();
        $("#form-registro").show();
        
    });
    $("#login").click(function(){
        $("#form-login").show();
        $("#form-registro").hide();
    });
    $("#registrarse").click(registroBoton);
    
    $("#form-login").keypress(function(e) {
		if (e.keyCode == 13 && !e.shiftKey) {
		      $("#boton-login").click();
		}
    });
    $("#boton-login").click(function(){
          var mail = $("#usuario").val();
          var pass = $("#password").val();
          var code = $("#captchaDiv").val();
          var pasa = 1;
          
          if(mail == ""){
                //$("#emailLog").addClass("has-error");
                pasa = 0;
          }else if(pass == ""){
                //$("#passLog").addClass("has-error");
                pasa = 0;
          }else if(!validar_email(mail)){
                pasa = 0;
          }
          if(pasa){
              $.ajax({
                  type: "POST",
                  url: "php/controles/controlLogin.php",
                  data: {"mail":mail,"pass":pass, "login":1, "code": code}
              })
              .done(function(data){
                      var not = $.parseJSON(data);
                   if(not.notice== 0)
					   alertify.error("No te has logeado");
                   
                   else if(not.notice == 1)
                         location.href="perfil.php";
                   
                   else if(not.notice == 2)
                       alertify.error("No has activado tu cuenta , mira tu email");
                   
                   else if(not.notice ==3)
                        document.getElementById("captchaDiv").innerHTML=" <img src='php/controles/creaCaptcha.php?"+(new Date()).getTime()+"'/><input type='text' id='code'/>";
                   
                  else if(not.notice ==4)
                        location.href="admin-panel.php";
                   
              });
          }
    });
    
 
});
      /*
    $("#repeatPassReg").change(function(){
     if($(this).val() != $("#passReg").val()){
        $("#divrepPass").addClass("has-error");  
     }else{
         $("#divrePass").removeClass("has-error");  
     }
    });
    */
	
	
	function validar_email(valor){
      // creamos nuestra regla con expresiones regulares.
      var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
      // utilizamos test para comprobar si el parametro valor cumple la regla
      if(filter.test(valor))
            return true;
      else
            return false;
	}

	function validar_password(valor2){
	 // creamos nuestra regla con expresiones regulares.
	  var retornar=0;
      if(valor2 >= 6)
           retornar=1; 	
      else
           retornar=0;
		
	return retornar;
	}
	

	// validacion de contraseña_registro
	function contrasenya_registro()
	{
		var retorn =0;
		var miCampoTexto2 = document.getElementById("contra").value;

		
		if($("#contra").val() == ''){
			alertify.error("El password no puede estar vacio");
			$("#contra").css( "border","3px solid red" );		
		}
		if((miCampoTexto2.length<=4)||(validar_password($("#contra").val())==true)){
			alertify.error("El password debe tener 5 o mas digitos");
			$("#contra").css( "border","3px solid red" );
		}
		else {
			document.getElementById("no_registro").innerHTML="";
			$("#contra").css( "border","1px solid blue" );
			retorn=1;
		}
		return retorn;
	}

	
	// validacion de contraseña_inicio
	function contrasenya_inicio()
	{
		var retorn =0;
		var miCampoTexto2 = document.getElementById("password").value;

		
		if($("#password").val() == ''){
			alertify.error("El password no puede estar vacio");
			$("#password").css( "border","3px solid red" );		
		}
		
		if((miCampoTexto2.length<=4)||(validar_password($("#password").val())==true)){
			alertify.error("El password debe tener 6 o mas digito");
			$("#password").css( "border","3px solid red" );
			
		}
		
		else {
			document.getElementById("no_logeo").innerHTML="";
			$("#password").css( "border","1px solid blue" );
			retorn=1;
		}
		return retorn;
	}
	

	// validacion de nombre_inicio
	function nombre_inicio()
	{
		var retorn =0;
		var miCampoTexto = document.getElementById("usuario").value;
		if (miCampoTexto.length <= 3) {
		alertify.error("El nombre debe tener un minimo de 3 digitos");
		$("#usuario").css( "border","3px solid red" );
		}
		else {
		document.getElementById("no_logeo").innerHTML="";
		$("#usuario").css( "border","1px solid blue" );
		retorn=1;
		}
		return retorn;
	}
	
	// validacion de nombre_registro
	function nombre_registro()
	{
		var retorn =0;
		var miCampoTexto = document.getElementById("nombre").value;
		if (miCampoTexto.length <= 3) {
		alertify.error("El nombre debe tener un minimo de 3 digitos");
		$("#nombre").css( "border","3px solid red" );
		}
		else {
		document.getElementById("no_registro").innerHTML="";
		$("#nombre").css( "border","1px solid blue" );
		retorn=1;
		}
		return retorn;
	}
	
	
	// validacion de apellido_registro
	function apellido_registro()
	{
		 var retorn =0;
		if($("#apellidos").val() == '')
		{
			alertify.error("El apellido no puede estar vacio");
			$("#apellidos").css( "border","3px solid red" );		
		}
		else {
			document.getElementById("no_registro").innerHTML="";
			$("#apellidos").css( "border","1px solid blue" );
			retorn=1;
		}
		return retorn;
	}
	
	
	
	// validacion de gmail_registro instantaneo
	function email_registro()
	{
		var retorn =0;
		if($("#email").val() == '')
		{
			alertify.error("Ingrese un email");
			$("#email").css( "border","3px solid red" );
		}else if(validar_email($("#email").val()))
		{
			document.getElementById("no_registro").innerHTML="";
			$("#email").css( "border","1px solid blue" );
			retorn=1;
		}else
		{
			alertify.error("Email incorrecto");
			$("#email").css( "border","3px solid red" );
		}
		return retorn;
	}




	// validacion de fecha_registro
	function dia_registro()
	{
		var retorn =0;
		if($("#dia").val() ==0)
		{
			$("#dia").css( "border","3px solid red" );	
		}
		else {
			$("#dia").css( "border","1px solid blue" );
			retorn=1;
		}
		return retorn;
	}
	
	function mes_registro()
	{
		var retorn =0;
		if($("#mes").val() ==0)
		{
			$("#mes").css( "border","3px solid red" );	
		}
		else {
			$("#mes").css( "border","1px solid blue" );
			retorn=1;
		}
		return retorn;
	}
	
	function any_registro()
	{
		var retorn =0;
		if($("#any").val() ==0)
		{
			$("#any").css( "border","3px solid red" );	
		}
		else {
			$("#any").css( "border","1px solid blue" );
			retorn=1;
		}
		return retorn;
	}
	

 function registroBoton(){
    var user = $("#nombre").val();
    var apellidos = $("#apellidos").val();
    var mail = $("#email").val();
    var pass = $("#contra").val();
    var dia = $("#dia").val();
    var mes = $("#mes").val();
    var anio = $("#any").val();
    var code = $("#code").val();
    var rePass = $("#repcontra").val();
    var fecha = dia+"/"+mes+"/"+anio;
      if(rePass == pass){
            if((apellido_registro()) && (email_registro()) && (contrasenya_registro()) && (nombre_registro()) && (dia_registro()) && (mes_registro()) && (any_registro())){
      			
                  $.ajax({
                        type: "POST",
                        url: "php/controles/controlRegistro.php",
                        data: {"user":user, "mail":mail,"pass":pass, "edad":fecha, "apellidos":apellidos, "codeCaptcha": code }
                    })
                    .done(function(data){
                          var not = $.parseJSON(data);
                         if(!not.notice){
                             alertify.error("no ha podido registrarse, prueva con otro email");
                         }else if(not.notice==3){
                                alertify.error("Codigo Captcha Mal escrito!!");
                         }else if(not.notice==4){
                                alertify.error("El email ya existe!");
                         }else{
                               alertify.success("Enhorabuena! Mira en tu correo y activalo!");
                         }
                    });
            }else{
                  alertify.error("Datos incorrectos");
            }
      }else
            alertify.error("las contraseñas no coinciden!");
    
    };
