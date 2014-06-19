$(function(){
	$("#formNuevoPais").submit(function(){
	//$("#guardarPais").click(function(){
		var error = 0;
		if($("#nombrePais").val() == ""){
			$("#alerta").val("Verifique que los campos esten completos");
			$("#nombrePais").css("border", "solid 1px red");
			error++;
		}else{
			$("#nombrePais").css("border", "solid 1px green");
		}
		if($("#infoPais").val() == ""){
			$("#alerta").val("Verifique que los campos esten completos");
			$("#infoPais").css("border", "solid 1px red");
			error++;
		}else{
			$("#infoPais").css("border", "solid 1px green");
		}
		if($("#coordenadasPais").val() == ""){
			$("#alerta").val("Verifique que los campos esten completos");
			$("#coordenadasPais").css("border", "solid 1px red");
			error++;
		}else{
			$("#coordenadasPais").css("border", "solid 1px green");
		}
		if(error == 0){
			$("#formNuevoPais").submit();

			var nombrePais = $("#nombrePais").val();
			var infoPais = $("#infoPais").val();
			var coordenadasPais = $("#coordenadasPais").val()

			document.enviar.nombrePais.value=nombrePais;
			document.enviar.infoPais.value=infoPais;
			document.enviar.coordenadasPais.value=coordenadasPais;
      		document.enviar.submit();
		}
		return false;
	});
	$("#formNuevaCiudad").submit(function(){
	//$("#guardarPais").click(function(){
		var error = 0;
		if($("#nombreCiudad").val() == ""){
			$("#alerta").val("Verifique que los campos esten completos");
			$("#nombreCiudad").css("border", "solid 1px red");
			error++;
		}else{
			$("#nombreCiudad").css("border", "solid 1px green");
		}
		if($("#infoCiudad").val() == ""){
			$("#alerta").val("Verifique que los campos esten completos");
			$("#infoCiudad").css("border", "solid 1px red");
			error++;
		}else{
			$("#infoCiudad").css("border", "solid 1px green");
		}
		if($("#coordenadasCiudad").val() == ""){
			$("#alerta").val("Verifique que los campos esten completos");
			$("#coordenadasCiudad").css("border", "solid 1px red");
			error++;
		}else{
			$("#coordenadasCiudad").css("border", "solid 1px green");
		}
		if($("#pertenecePais").val() == ""){
			$("#alerta").val("Verifique que los campos esten completos");
			$("#pertenecePais").css("border", "solid 1px red");
			error++;
		}else{
			$("#pertenecePais").css("border", "solid 1px green");
		}
		if(error == 0){
			$("#formNuevaCiudad").submit();

			var nombreCiudad = $("#nombreCiudad").val();
			var infoCiudad = $("#infoCiudad").val();
			var coordenadasCiudad = $("#coordenadasCiudad").val();
			var pertenecePais = $("#pertenecePais").val();

			document.enviar.nombreCiudad.value=nombreCiudad;
			document.enviar.infoCiudad.value=infoCiudad;
			document.enviar.coordenadasCiudad.value=coordenadasCiudad;
			document.enviar.pertenecePais.value=pertenecePais;
      		document.enviar.submit();
		}else
		      alertify.error("hay errores!!!");
		return false;
	});
});