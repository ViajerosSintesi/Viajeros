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
                  
			if(res.indexOf("[perfil")>1){
			      //alertify.alert(res+" - "+res.indexOf("[perfil"));
                        var strUser = res.substr(0,res.indexOf("[perfil"));
			      var htmlInsert ='<form method="post" action="perfil.php" class="envioPerfil">';
                        htmlInsert +='<input type="hidden" value="'+strUser+'" name="user"/></form>';
			      $(this).html(htmlInsert);
			      $(".envioPerfil").submit();
			}else{
			      window.location=res;
			}
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
	
	$("#mensajes").click(function(){
	      var userId = $("#userIdForImg").val();
	      recibirMnsj(userId);
	})
	
});

function borrarImagen(imgId, carga){
      var dataEnvio = {"borrarImagen": 1, "imagenId": imgId};
      $.getJSON('php/controles/controlImagen.php', dataEnvio, function(data){
            console.log(data);
            if(data){
                  alertify.success("imagen borrada!");
                   location.reload(true);
            }else
                  alertify.error("no se ha podido borrar!");
            //console.log(this.parentNode.nodeName);
      });
}

function recibirMnsj(user){
      var query = {"user":user, verMnsjRec:1};
      $.getJSON("php/controles/controlMensajes.php", query, function(data){
            var htmlinsert = "";
            if(data){
                  for(var i = 0; i<data.length; i++){
                        htmlinsert +="de: "+data[i].nomRemitente+"<br>";
                        htmlinsert +="mensaje: "+data[i].texto+"<br>";
                        htmlinsert +="fecha: "+data[i].fecha+"<br>";
                        htmlinsert +="<hr>";
                  }
            }
            
            alertify.alert(htmlinsert);
      });
}


function reportarImagen(imagen,user){
      var imgId = imagen;
	  var userId = user;
      
      var dataEnvio = {"reportarImg": 1, "imgId": imgId, "userId": userId};
      
      $.getJSON('php/controles/controlReporte.php', dataEnvio, function(data){
            console.log(data);
            if(data){ location.reload(true);
                  alertify.success("imagen reportada! Gracias por tu ayuda!");
            }else{
                  alertify.error("no se ha podido reportar :(");
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
                                    if(data){
                                          alertify.success("Genial! sigue valorando! :)");
                                    }else{
                                           alertify.error("no ha podido guardarse la valoracion :(");
                                    }
                                    });
                        break;
            case 'img':
                  var imgId = object;
                  var userId = user;

                  var dataEnvio = {"valorimg": valor, "imagenId": imgId, "userId": userId};
                  $.getJSON('php/controles/controlValoracionImg.php', dataEnvio, function(data){
                        console.log(data);
                        if(data){
                              alertify.success("Genial! sigue valorando! :)");
                        }else{
                               alertify.error("no ha podido guardarse la valoracion :(");
                        }
                  });
                  break;
            case 'pregunta': 
                        var dataEnvio = {"userId": user, 
                                         "pregunta": object, 
                                         "valorPregunta": valor};
                        $.getJSON("php/controles/controlValoracionPregunta.php",
                                    dataEnvio, function(data){
                                    console.log(data);
                                    if(data){
                                          alertify.success("Genial! sigue valorando! :)");
                                    }else{
                                           alertify.error("no ha podido guardarse la valoracion :(");
                                    }
                                    });
                        break;
            case 'respuesta': 
                        var dataEnvio = {"userId": user, 
                                         "respuesta": object, 
                                         "valorRespuesta": valor};
                        $.getJSON("php/controles/controlValoracionRespuesta.php",
                                    dataEnvio, function(data){
                                    console.log(data);
                                    if(data){
                                          alertify.success("Genial! sigue valorando! :)");
                                    }else{
                                           alertify.error("no ha podido guardarse la valoracion :(");
                                    }
                                    });
                        break;
            default: break;
      }
}

function imgDialog(userId, divId, borra){
      
     
      $("#"+divId).html("");
      
      var htmlInsert = '';
      var dataImgValoracion = {"verValor": 1, "userId": userId, "img":divId};
      
      $.getJSON("php/controles/controlValoracionImg.php", dataImgValoracion, function(data){
      //console.log(data);

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

           if(borra) htmlInsert +='<input type="button" class="borrarImg" value="borrar" name="'+divId+'"/>';
            htmlInsert +='<input type="button" class="reportarImg" value="reportar" name="'+divId+'"/>';
            
            $("#"+divId).html( $("#"+divId).html()+htmlInsert);
            $(".meGusta").click(function(){
                 $("#"+divId).dialog("close");
                  enviarValoracion("img", 2, userId, divId);
                  imgDialog(userId, divId, borra);
            });
            
            $(".noMeGusta").click(function(){
                  $("#"+divId).dialog("close");
                  enviarValoracion("img", 1, userId, divId);
                  imgDialog(userId, divId, borra);
            });
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
			modal: false,
			title: "Caja con opciones",
			width: 720,
			minWidth: 720,
			maxWidth: 1080,
			maxHeight: 1080,
			show: "fold",
			hide: "scale"
			});
                  
}
