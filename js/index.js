$(document).ready(function(){


	
	
	// validacion de contraseña_registro
	$("#contra").change(contrasenya_registro);
	

	// validacion de nombre_registro
	$("#nombre").change(nombre_registro);
	
	
	// validacion de apellido_registro
	$("#apellidos").change(apellido_registro);
	
	
	// validacion de gmail_registro instantaneo
	$("#email").change(email_registro);
	

	
	
	
	
	
	
	
	
	

	
	

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
    
    $("#boton-login").click(function(){
          var mail = $("#usuario").val();
          var pass = $("#password").val();
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
                  url: "php/controlLogin.php",
                  data: {"mail":mail,"pass":pass, "login":1}
              })
              .done(function(data){
                      var not = $.parseJSON(data);
                   if(!not.notice){
					   document.getElementById("no_logeo").innerHTML="No te has logeado";
                   }
                   if(not.notice == 1){
                         location.href="perfil.php";
                   }
                   if(not.notice == 2){
                       document.getElementById("no_logeo").innerHTML="No has activado tu cuenta , mira tu email";
                   }
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
	
	

	
	// validacion de contraseña_registro
	function contrasenya_registro()
	{
		var retorn =0;
		var miCampoTexto2 = document.getElementById("contra").value;
		if($("#contra").val() == ''){
			document.getElementById("no_registro").innerHTML="El password no puede estar vacio";
			$("#contra").css( "border","3px solid red" );		
		}
		
		if(miCampoTexto2.length<=5){
			document.getElementById("no_registro").innerHTML="El password debe tener 5 o mas digitos";
			$("#contra").css( "border","3px solid red" );
			
		}
		
		if(miCampoTexto2.length>=5){
			document.getElementById("no_registro").innerHTML="";
			$("#contra").css( "border","1px solid blue" );
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
		document.getElementById("no_registro").innerHTML="El nombre debe tener un minimo de 3 digitos";
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
			document.getElementById("no_registro").innerHTML="El apellido no puede estar vacio";
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
			document.getElementById("no_registro").innerHTML="Ingrese un email";
			$("#email").css( "border","3px solid red" );
		}else if(validar_email($("#email").val()))
		{
			document.getElementById("no_registro").innerHTML="";
			$("#email").css( "border","1px solid blue" );
			retorn=1;
		}else
		{
			document.getElementById("no_registro").innerHTML="Email incorrecto";
			$("#email").css( "border","3px solid red" );
		}
		return retorn;
	}




	// validacion de fecha_registro
	function fecha_registro()
	{
		if($("#dia").val() ==0)
		{
			alert("dia incorrecto");	
		}
		else {
			alert("fecha correcta");
		}
	}
	



 function registroBoton(){
    var user = $("#nombre").val();
    var apellidos = $("#apellidos").val();
    var mail = $("#email").val();
    var pass = $("#password").val();
    var dia = $("#dia").val();
    var mes = $("#mes").val();
    var anio = $("#any").val();
    
    var fecha = dia+"/"+mes+"/"+anio;
   
		  
		  
		  
      if((apellido_registro()) && (email_registro()) && (contrasenya_registro()) && (nombre_registro())){
			
            $.ajax({
                  type: "POST",
                  url: "php/controlRegistro.php",
                  data: {"user":user, "mail":mail,"pass":pass, "edad":fecha, "apellidos":apellidos }
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
            alert("Datos incorrectos");
      }
    
    };