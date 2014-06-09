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

	
});
function cargarComents(idSitio, idUser, tipo){
           var dataEnvio = {
                        "ciudad": idSitio,
                        "userId": idUser,
                        "verComments":tipo
                  }
           $.getJSON("php/controles/controlComment.php", dataEnvio, function(data){
             //console.log(data);
             var htmlInsert = ""; 
             for(var i = 0; i<data.length; i++){
                  htmlInsert +='<div class="coments">';
                  htmlInsert +='<div class="coment-up">';
                  htmlInsert +='<p><a href="perfil.php?user='+data[i].idUsu+'"><img class="imgperfil" src="'+data[i].imgPerfilUser+'"/>'+data[i].nombreDelUser+'</a></p>';
      	      htmlInsert +='<p>'+data[i].comentario+'</p>';
      	      htmlInsert +='<input type="hidden" id="idUsu'+i+'" value="'+idUser+'"/>';
      	      htmlInsert +='<input type="hidden" id="idComent'+i+'" value="'+data[i]._id['$id']+'"/>';
                  
                  htmlInsert +='</div>';
                  htmlInsert +='<div class="coment-down">';
                  htmlInsert +='<span class="fecha">'+data[i].data+'</span>';
      	      htmlInsert +='<button title="me gusta" class="meGusta" id="coment-'+i+'"><span id="countPos'+i+'">'+data[i].valorPos+'</span>';
      	      if(data[i].valorDelUser){
      	            if(data[i].valorDelUser.valor == 2) htmlInsert +='<img src="img/hand_pro_verde.png" >';
      	            else htmlInsert +='<img src="img/hand_pro.png" >';
      	      }else htmlInsert +='<img src="img/hand_pro.png" >';
      	      htmlInsert +='</button>';
      	      htmlInsert +='<button title="no me gusta" class="noMeGusta" id="coment-'+i+'"><span id="countNeg'+i+'">'+data[i].valorNeg+'</span>';
      	      if(data[i].valorDelUser){
      	            if(data[i].valorDelUser.valor == 1) htmlInsert +='<img src="img/hand_contra_roja.png" >';
      	            else htmlInsert +='<img src="img/hand_contra.png" >';
      	      }else htmlInsert +='<img src="img/hand_contra.png" >';
      	      htmlInsert +='</button>';
      	      htmlInsert +='<button title="reportar abuso" class="reportButton" id="report-'+i+'"><img src="img/hand_1.png" /></button>';
                  htmlInsert +='</div>';
                  htmlInsert +='</div>';
             }
            
	      htmlInsert +='<div id="subirComent">';
		htmlInsert +='<form action="#" method="post">';
		htmlInsert +='<textarea id="areatexto" cols="80" rows="5"></textarea>';
		htmlInsert +='<input type="hidden" id="idUser" value="'+idUser+'"/>';
		htmlInsert +='<input type="hidden" id="idSitio" value="'+idSitio+'"/>';
		htmlInsert +='<input type="hidden" id="tipo" value="'+tipo+'"/>';
		
		htmlInsert +='<!-- <input type="submit" id="kiko" value="enviar"> -->';
	      htmlInsert +='</form>';
            htmlInsert +='</div>';
            
             $("#comentarios-pais").html(htmlInsert);
             $(".meGusta").click(function(){
                  var id=$(this).attr("id");
                  var numComent = id[id.length-1];
                  //console.log(numComent);
                  var idUsu= $("#idUsu"+numComent).val();
                  var idComment= $("#idComent"+numComent).val();
                  enviarValoracion("comment", 2, idUsu, idComment);
                  cargarComents(idSitio, idUser, tipo);
            });
            
            $(".noMeGusta").click(function(){
                  var id=$(this).attr("id");
                  var numComent = id[id.length-1];
                  //console.log(numComent);
                  var idUsu= $("#idUsu"+numComent).val();
                  var idComment= $("#idComent"+numComent).val();
                  enviarValoracion("comment", 1, idUsu, idComment);
                  cargarComents(idSitio, idUser, tipo);
            });
            $("#areatexto").keypress(function(e) {
      		if (e.keyCode == 13 && !e.shiftKey) {
      			e.preventDefault();
      			var comentario = $("#areatexto").val();
      			var idUser = $("#idUser").val();
      			var idSitio = $("#idSitio").val();
      			var tipo = $("#tipo").val();
      			var fecha = new Date().toString();
      			var dataEnvio = {
      			   "comentario":comentario, 
      			   "userId": idUser,
      			   "ciudad": idSitio,
      			   "insertarComent": tipo,
      			   "fecha": fecha
      			   };

      			$.getJSON("php/controles/controlComment.php", dataEnvio, function(data){
      			      
      			      cargarComents(idSitio, idUser, tipo);
      			      
      			});
      		
      		}
            });
             $(".reportButton").click(function(){
                  var id=$(this).attr("id");
                  var numComent = id[id.length-1];
                  //console.log(numComent);
                  var idUsu= $("#idUsu"+numComent).val();
                  var idComment= $("#idComent"+numComent).val();
                  
                  var dataEnvio = {
                              "reportarComent": tipo,
                              "userId": idUsu,
                              "comentId": idComment
                              };
                  $.getJSON("php/controles/controlReporte.php", dataEnvio, function(data){
                        console.log(data);
                  });
            });
           }); 
   
      }

function cargarPreguntas(idSitio, idUser, tipo){
           var dataEnvio = {
                        "ciudad": idSitio,
                        "userId": idUser,
                        "verPreguntas":tipo
                  }
           $.getJSON("php/controles/controlPregunta.php", dataEnvio, function(data){
             //console.log(data);
             var htmlInsert = ""; 
             for(var i = 0; i<data.length; i++){
                  htmlInsert +='<div class="pregunta">';
                  htmlInsert +='<div class="pregunta-up">';
                  htmlInsert +='<p><a href="perfil.php?user='+data[i].idUsu+'"><img class="imgperfil" src="'+data[i].imgPerfilUser+'"/>'+data[i].nombreDelUser+'</a></p>';
      	      htmlInsert +='<p>'+data[i].pregunta+'</p>';
      	      htmlInsert +='<input type="hidden" id="idUsu'+i+'" value="'+idUser+'"/>';
      	      htmlInsert +='<input type="hidden" id="idPregunta'+i+'" value="'+data[i]._id['$id']+'"/>';
                  
                  htmlInsert +='</div>';
                  htmlInsert +='<div class="pregunta-down">';
                  htmlInsert +='<span class="fecha">'+data[i].data+'</span>';
      	      htmlInsert +='<button title="me gusta" class="meGusta" id="pregunta-'+i+'"><span id="countPos'+i+'">'+data[i].valorPos+'</span>';
      	      if(data[i].valorDelUser){
      	            if(data[i].valorDelUser.valor == 2) htmlInsert +='<img src="img/hand_pro_verde.png" >';
      	            else htmlInsert +='<img src="img/hand_pro.png" >';
      	      }else htmlInsert +='<img src="img/hand_pro.png" >';
      	      htmlInsert +='</button>';
      	      htmlInsert +='<button title="no me gusta" class="noMeGusta" id="pregunta-'+i+'"><span id="countNeg'+i+'">'+data[i].valorNeg+'</span>';
      	      if(data[i].valorDelUser){
      	            if(data[i].valorDelUser.valor == 1) htmlInsert +='<img src="img/hand_contra_roja.png" >';
      	            else htmlInsert +='<img src="img/hand_contra.png" >';
      	      }else htmlInsert +='<img src="img/hand_contra.png" >';
      	      htmlInsert +='</button>';
      	      htmlInsert +='<button title="reportar abuso" class="reportButton" id="report-'+i+'"><img src="img/hand_1.png" /></button>';
                  htmlInsert +='</div>';
                  htmlInsert +='<button title="ver respuestas" class="ver-respuesta" id="report-'+i+'">respuestas</button>';
                  htmlInsert +='<div class="rspta"><div id="'+data[i]._id['$id']+'"></div></div>';
                   
                  htmlInsert +='</div>';
             }
            
	      htmlInsert +='<div id="subirPregunta">';
		htmlInsert +='<form action="#" method="post">';
		htmlInsert +='<textarea id="areatexto" cols="80" rows="5"></textarea>';
		htmlInsert +='<input type="hidden" id="idUser" value="'+idUser+'"/>';
		htmlInsert +='<input type="hidden" id="idSitio" value="'+idSitio+'"/>';
		htmlInsert +='<input type="hidden" id="tipo" value="'+tipo+'"/>';
		
		htmlInsert +='<!-- <input type="submit" id="kiko" value="enviar"> -->';
	      htmlInsert +='</form>';
            htmlInsert +='</div>';
            
             $("#preguntas-pais").html(htmlInsert);
             $(".meGusta").click(function(){
                  var id=$(this).attr("id");
                  var numPregunta = id[id.length-1];
                  //console.log(numPregunta);
                  var idUsu= $("#idUsu"+numPregunta).val();
                  var idPregunta= $("#idPregunta"+numPregunta).val();
                  enviarValoracion("pregunta", 2, idUsu, idPregunta);
                  cargarPreguntas(idSitio, idUser, tipo);
            });
            
            $(".noMeGusta").click(function(){
                  var id=$(this).attr("id");
                  var numPregunta = id[id.length-1];
                  //console.log(numPregunta);
                  var idUsu= $("#idUsu"+numPregunta).val();
                  var idPregunta= $("#idPregunta"+numPregunta).val();
                  enviarValoracion("pregunta", 1, idUsu, idPregunta);
                  cargarPreguntas(idSitio, idUser, tipo);
            });
            $("#areatexto").keypress(function(e) {
      		if (e.keyCode == 13 && !e.shiftKey) {
      			e.preventDefault();
      			var pregunta = $("#areatexto").val();
      			var idUser = $("#idUser").val();
      			var idSitio = $("#idSitio").val();
      			var tipo = $("#tipo").val();
      			var fecha = new Date().toString();

      			var dataEnvio = {
      			   "pregunta":pregunta, 
      			   "userId": idUser,
      			   "ciudad": idSitio,
      			   "insertarPregunta": tipo,
      			   "fecha": fecha
      			   };
      			$.getJSON("php/controles/controlPregunta.php", dataEnvio, function(data){
      			      
      			      cargarPreguntas(idSitio, idUser, tipo);
      			     
      			});
      		}
            });
             $(".reportButton").click(function(){
                  var id=$(this).attr("id");
                  var numPregunta = id[id.length-1];
                  //console.log(numPregunta);
                  var idUsu= $("#idUsu"+numPregunta).val();
                  var idPregunta= $("#idPregunta"+numPregunta).val();
                  
                  var dataEnvio = {
                              "reportarPregunta": tipo,
                              "userId": idUsu,
                              "preguntaId": idPregunta
                              };
                  $.getJSON("php/controles/controlReporte.php", dataEnvio, function(data){
                        console.log(data);
                  });
            });
            $(".ver-respuesta").click(function(){
                  
                  var id=$(this).attr("id");
                  var numPregunta = id[id.length-1];
                
                  var idPregunta= $("#idPregunta"+numPregunta).val();
                  var idUser = $("#idUser").val();
      		var idSitio = $("#idSitio").val();
                  cargarRespuestas(idPregunta,idUser, tipo);
            });
           }); 
   
      }
      
           
      
function cargarRespuestas(idSitio, idUser, tipo){
            
           var dataEnvio = {
                        "pregunta": idSitio,
                        "userId": idUser,
                        "verRespuestas":tipo
                  }
           $.getJSON("php/controles/controlRespuesta.php", dataEnvio, function(data){
             //console.log(data);
             var htmlInsert = ""; 
             for(var i = 0; i<data.length; i++){
                  htmlInsert +='<div class="respuesta">';
                  htmlInsert +='<div class="respuesta-up">';
                  htmlInsert +='<p><a href="perfil.php?user='+data[i].idUsu+'"><img class="imgperfil" src="'+data[i].imgPerfilUser+'"/>'+data[i].nombreDelUser+'</a></p>';
      	      htmlInsert +='<p>'+data[i].respuesta+'</p>';
      	      htmlInsert +='<input type="hidden" id="idUsu'+i+'" value="'+idUser+'"/>';
      	      htmlInsert +='<input type="hidden" id="idRespuesta'+i+'" value="'+data[i]._id['$id']+'"/>';
                  
                  htmlInsert +='</div>';
                  htmlInsert +='<div class="respuesta-down">';
                  htmlInsert +='<span class="fecha">'+data[i].data+'</span>';
      	      htmlInsert +='<button title="me gusta" class="meGusta" id="respuesta-'+i+'"><span id="countPos'+i+'">'+data[i].valorPos+'</span>';
      	      if(data[i].valorDelUser){
      	            if(data[i].valorDelUser.valor == 2) htmlInsert +='<img src="img/hand_pro_verde.png" >';
      	            else htmlInsert +='<img src="img/hand_pro.png" >';
      	      }else htmlInsert +='<img src="img/hand_pro.png" >';
      	      htmlInsert +='</button>';
      	      htmlInsert +='<button title="no me gusta" class="noMeGusta" id="respuesta-'+i+'"><span id="countNeg'+i+'">'+data[i].valorNeg+'</span>';
      	      if(data[i].valorDelUser){
      	            if(data[i].valorDelUser.valor == 1) htmlInsert +='<img src="img/hand_contra_roja.png" >';
      	            else htmlInsert +='<img src="img/hand_contra.png" >';
      	      }else htmlInsert +='<img src="img/hand_contra.png" >';
      	      htmlInsert +='</button>';
      	      htmlInsert +='<button title="reportar abuso" class="reportButton" id="report-'+i+'"><img src="img/hand_1.png" /></button>';
                  htmlInsert +='</div>';
                  htmlInsert +='</div>';
             }
            
	      htmlInsert +='<div id="subirRespuesta">';
		htmlInsert +='<form action="#" method="post">';
		htmlInsert +='<textarea id="areaTextoResp" cols="80" rows="5"></textarea>';
		htmlInsert +='<input type="hidden" id="idUser" value="'+idUser+'"/>';
		htmlInsert +='<input type="hidden" id="idSitio" value="'+idSitio+'"/>';
		htmlInsert +='<input type="hidden" id="tipo" value="'+tipo+'"/>';
		
		htmlInsert +='<!-- <input type="submit" id="kiko" value="enviar"> -->';
	      htmlInsert +='</form>';
            htmlInsert +='</div>';
            
             $("#"+idSitio).html(htmlInsert);
             
             $(".meGusta").click(function(){
                  var id=$(this).attr("id");
                  var numRespuesta = id[id.length-1];
                  //console.log(numRespuesta);
                  var idUsu= $("#idUsu"+numRespuesta).val();
                  var idRespuesta= $("#idRespuesta"+numRespuesta).val();
                  enviarValoracion("respuesta", 2, idUsu, idRespuesta);
                  cargarRespuestas(idSitio, idUser, tipo);
            });
            
            $(".noMeGusta").click(function(){
                  var id=$(this).attr("id");
                  var numRespuesta = id[id.length-1];
                  //console.log(numRespuesta);
                  var idUsu= $("#idUsu"+numRespuesta).val();
                  var idRespuesta= $("#idRespuesta"+numRespuesta).val();
                  enviarValoracion("respuesta", 1, idUsu, idRespuesta);
                  cargarRespuestas(idSitio, idUser, tipo);
            });
            $("#areaTextoResp").keypress(function(e) {
      		if (e.keyCode == 13 && !e.shiftKey) {
      			e.preventDefault();
      			var respuesta = $("#areaTextoResp").val();
      			var idUser = $("#idUser").val();
      			var idSitio = $("#idSitio").val();
      			var tipo = $("#tipo").val();
      			var fecha = new Date().toString();
      			var dataEnvio = {
      			   "respuesta":respuesta, 
      			   "userId": idUser,
      			   "pregunta": idSitio,
      			   "insertarRespuesta": tipo,
      			   "fecha": fecha
      			   };
      			$.getJSON("php/controles/controlRespuesta.php", dataEnvio, function(data){
      			      
      			      cargarRespuestas(idSitio, idUser, tipo);
      			      
      			});
      		}
            });
            
             $(".reportButton").click(function(){
                  var id=$(this).attr("id");
                  var numRespuesta = id[id.length-1];
                  //console.log(numRespuesta);
                  var idUsu= $("#idUsu"+numRespuesta).val();
                  var idRespuesta= $("#idRespuesta"+numRespuesta).val();
                  
                  var dataEnvio = {
                              "reportarRespuesta": tipo,
                              "userId": idUsu,
                              "respuestaId": idRespuesta
                              };
                  $.getJSON("php/controles/controlReporte.php", dataEnvio, function(data){
                        console.log(data);
                  });
            });

      });
}
