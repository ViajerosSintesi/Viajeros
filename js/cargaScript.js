$(function(){
	$("#cancelar-datos").click(function(){
		alert("clickado en cancelar");
		return false;
	});
	$("#modificar-datos").click(function(){
		alert("clickado en modificar");
		return false;
	});
	$("#kiko").click(function(){
		alert("envio comentario");
		return false;
	});
	$("#areatexto").keypress(function(e) {
		if (e.keyCode == 13 && !e.shiftKey) {
			e.preventDefault();
			alert('sending comment...');
		}
	});
	
	
	$("#areatexto-ciudad").keypress(function(e) {
		if (e.keyCode == 13 && !e.shiftKey) {
			e.preventDefault();
			var comentario = $("#areatexto").val();
			var idUser = $("#idUsert").val();
			var idSitio = $("#idSitio").val();
			var tipo = $("#tipo").val();
			
			var dataEnvio = {
			   "comentario":comentario, 
			   "userId": idUser,
			   "ciudad": idSitio,
			   "insertarComent": tipo
			   };
			$.getJSON("php/controles/controlComment.php", dataEnvio, function(data){
			      console.log(data);
			});
		}
	});
	
	//hay que mirarselo que no funciona
	//$("#areatexto").elastic();
	//$("#areatexto-ciudad").elastic();

	
});

