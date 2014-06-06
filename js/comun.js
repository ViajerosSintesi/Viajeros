$(function(){
	//esconde el cuadro para subir imagenes
	$("#bg-cuadro").hide();
	$("#cuadro-foto").hide();
	$("#mapa-ubicacion").hide();
	//si se hace click al boton de subir imagenes, aparece el cuadro
	$("#subir-foto").click(function(){
		$("#bg-cuadro").show();
		$("#cuadro-foto").show();
	});
	//Mostrar el mapa de ubicacion actual
	$("#miUbicacion").click(function(){
		$("#bg-cuadro").show();
		//geolocalizacion();
		$("#mapa-ubicacion").append("<iframe src='geolocalizacion.php' id='geolocalizacion'></iframe>");
		$("#mapa-ubicacion").show();
	});
	//cerrar el cuadro de subri fotos
	$(".cerrar-cuadro").click(function(){
		$("#bg-cuadro").hide();
		$("#cuadro-foto").hide();
		$("#mapa-ubicacion").hide();
		$("#geolocalizacion").remove();
	});
	$("#buscar" ).autocomplete({
		source: buscador,
		select: function(){
			var res = document.getElementById("id").value;
			window.location=res;
		}
	});
	//Menu
	$("#hide-show-menu").click(function(){
		$("#barra-menu").toggle("slow",function(){
			var src = ($("#ico-menu").attr('src') === 'img/33.png')
			? 'img/32.png'
			: 'img/33.png';
			$("#ico-menu").attr('src', src);
		});
	});
});

function borrarImagen(imgId, carga){
     
      
      var dataEnvio = {"borrarImagen": 1, "imagenId": imgId};
      $.getJSON('php/controles/controlImagen.php', dataEnvio, function(data){
            console.log(data);
            if(data){
                   location.reload(true);
            }
            //console.log(this.parentNode.nodeName);
      });
}



function reportarImagen(imagen,user){
      var imgId = imagen;
	  var userId = user;
      
      var dataEnvio = {"reportarImg": 1, "imgId": imgId, "userId": userId};
      
      $.getJSON('php/controles/controlReporte.php', dataEnvio, function(data){
            console.log(data);
            if(data){ location.reload(true);
                  alert("imagen reportada! Gracias por tu ayuda!");
            }
            //console.log(this.parentNode.nodeName);
      });
}


function enviarValoracion(tipo, valor, user, object){
      switch(tipo){
            case 'comment': 
                        var dataEnvio = {"userId": user, 
                                         "coment": object, 
                                         "valorComent": valor};
                        $.getJSON("php/controles/controlValoracionComent.php",
                                    dataEnvio, function(data){
                                    console.log(data);
                                    });
                        break;
            case 'img':
                  var imgId = object;
                  var userId = user;

                  var dataEnvio = {"valorimg": valor, "imagenId": imgId, "userId": userId};
                  $.getJSON('php/controles/controlValoracionImg.php', dataEnvio, function(data){
                        console.log(data);
                  });
                  break;
            case 'pregunta': 
                        var dataEnvio = {"userId": user, 
                                         "pregunta": object, 
                                         "valorPregunta": valor};
                        $.getJSON("php/controles/controlValoracionPregunta.php",
                                    dataEnvio, function(data){
                                    console.log(data);
                                    });
                        break;
            case 'respuesta': 
                        var dataEnvio = {"userId": user, 
                                         "respuesta": object, 
                                         "valorRespuesta": valor};
                        $.getJSON("php/controles/controlValoracionRespuesta.php",
                                    dataEnvio, function(data){
                                    console.log(data);
                                    });
                        break;
            default: break;
      }
}

function imgDialog(userId, divId, borra){
      
                 
                  $("#"+divId).html("");
               var dataImgValoracion = {"verValor": 1, "userId": userId, "img":divId};
                  $.getJSON("php/controles/controlValoracionImg.php", dataImgValoracion, function(data){
                        //console.log(data);
                         var htmlInsert = "";
                        if(data){
                              htmlInsert ='<button title="me gusta" class="meGusta"><span id="countPos">'+data.valores.valorPos+'</span>';
                  	      if(data.valorUsu){
                  	            if(data.valorUsu.valor == 2) htmlInsert +='<img src="img/hand_pro_verde.png" >';
                  	            else htmlInsert +='<img src="img/hand_pro.png" >';
                  	      }else htmlInsert +='<img src="img/hand_pro.png" >';
                  	      htmlInsert +='</button>';
                  	      htmlInsert +='<button title="no me gusta" class="noMeGusta"><span id="countNeg">'+data.valores.valorNeg+'</span>';
                  	      if(data.valorUsu){
                  	            if(data.valorUsu.valor == 1) htmlInsert +='<img src="img/hand_contra_roja.png" >';
                  	            else htmlInsert +='<img src="img/hand_contra.png" >';
                  	      }else htmlInsert +='<img src="img/hand_contra.png" >';
                  	      htmlInsert +='</button>';
                        }
      	      $("#"+divId).html( $("#"+divId).html()+htmlInsert);
                  
                  $(".meGusta").click(function(){
                       alert("hola");
                        enviarValoracion("img", 2, userId, divId);
                        $("#"+divId).dialog("close", "duration", 1000);
                        imgDialog(userId);
                        
                  });
                  
                  $(".noMeGusta").click(function(){
                        enviarValoracion("img", 1, userId, divId);
                        $("#"+divId).dialog("close", "duration", 1000);
                        imgDialog(userId);
                  });
                  if(borra) $("#"+divId).html($("#"+divId).html()+'<input type="button" class="borrarImg" value="borrar" name="'+divId+'"/>');
                  $("#"+divId).html($("#"+divId).html()+'<input type="button" class="reportarImg" value="reportar" name="'+divId+'"/>');
                
                  $('.borrarImg').click(function(){
                        
                        borrarImagen(divId);
                        $("#"+divId).dialog("close", "duration", 1000);
                  });
                  $('.reportarImg').click(function(){
                        reportarImagen(divId, userId);
                        $("#"+divId).dialog("close", "duration", 1000);
                  });
                  });
                  
                  $("#"+divId).append($("img[name='"+divId+"']").clone());
		      $("#"+divId+">img").addClass("imagen-dialogo");
                  $("#"+divId).dialog({
				    
					modal: true,
					title: "Caja con opciones",
					width: 720,
					minWidth: 720,
					maxWidth: 1080,
					maxHeight: 1080,
					show: "fold",
					hide: "scale"
					});
            
}