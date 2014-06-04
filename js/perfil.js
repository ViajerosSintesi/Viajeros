/**
 *
 * Perfil.js
 * 
 * controlador para el perfil
 * 
 **/
$(function(){
      
            //esta funcion carga los datos del usuario en sus campos
            cargarDatos();
            //esconde el cuadro para subir imagenes
            $("#bg-cuadro").hide();
            $("#cuadro-foto").hide();
            $("#mapa-ubicacion").hide();
            //esconde el fomulario para modificar la informacion del usuario
            $("#form-info").hide();
            //si se hace click en el boton de modificar, se abre el formulario
            $("#perfil-edit").click(function(){
                  //actualizaPerfil();
                  $("#info").hide();
                  $("#form-info").show();
            });
            //si se cancela, se esconde el formulario 
            $("#cancelar-datos").click(function(){
                  $("#form-info").hide();
                  $("#info").show();
            });
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
            
            //al aceptar los cambios, modificas la informacion
            $("#modificar-datos").click(modPerfil);
            //si se elige foto, la sube
            $('#foto-perfil').change(subirImgPerfil);

            //reutilizable, es para buscar. la funcion buscador esta en js/buscador.js
            $("#buscar" ).autocomplete({
                  source: buscador,
                  select: function(){
                        var res = document.getElementById("id").value;
                        window.location=res;
                  }
            });
            $("#buscarForImg" ).autocomplete({
                  source: buscador
            });
            
            $("#formfotos").submit(subirFotos);
            //Menu
            $("#hide-show-menu").click(function(){
                  $("#barra-menu").toggle("slow",function(){
                        var src = ($("#ico-menu").attr('src') === 'img/33.png')
                        ? 'img/32.png'
                        : 'img/33.png';
                        $("#ico-menu").attr('src', src);
                  });
            });
            //Mostrar esconder logout
            $("#show-logout").click(function(){
                  $("#div-logout").show();
            })
            $("#show-logout").mouseleave(function(){
                  $("#div-logout").hide();
            });
            
});
/**
 *
 * subir imagen al pefil
 * 
 * ------------------Falta comprobacion de peso i extension sobretodo
 * 
 **/
function subirImgPerfil(){
            var file = $("#foto-perfil")[0].files[0];
		//obtenemos el nombre del archivo
		var fileName = file.name;
		//obtenemos la extensión del archivo
		var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
		//obtenemos el tamaño del archivo
		var fileSize = file.size;
		//obtenemos el tipo de archivo image/png ejemplo
		var fileType = file.type;
		
		
		if ((fileSize<=200000) && (fileExtension=="jpeg") || (fileExtension=="png") || (fileExtension=="jpg")){
                  //creamos un form data i añadimos el fichero
                  var formData = new FormData();
                  formData.append("imgPerfil", file);
                  
                  //ejecutamos ajax para que conecte con el servidor y pueda modificar
                  $.ajax({
                  	url: 'php/controles/modificarPerfil.php',  
                  	type: 'POST',
                  	data: formData,
                  	cache: false,
                  	contentType: false,
                  	processData: false,
                  	success: function(data){
                  	     //si todo va bien, vuelve a cargar los datos
                  	    if(data==1) cargarDatos();
                  	    else alert("no se ha subido");// <<<<-----No alerts loco!
                  	}
                  });
		}else {
		      alert("La imagen es demasiado grande o no cumple el formato correcto");
		}
}
/**
 * funcion que dado una extension comprueba que se de imagen
 * 
 * return boolean       1: extension de imagen
 *                      0: no es extension de imagen
 * 
 **/
function isImage(extension){
	switch(extension.toLowerCase()) 
	{
	    case 'jpg': case 'gif': case 'png': case 'jpeg':
	        return true;
	    break;
	    default:
	        return false;
	    break;
    }
}

/**
 * le pide los datos al servidor y rellena los campos del perfil
 * 
 **/
function cargarDatos(){
       $("body").append("<div id='cargaAjax'> <img src='img/gif-load.gif'/></div>");
       $("#cargaAjax").dialog({modal:true});
      var userId = $("#userIdForImg").val();
      var dataEnvio = {"datosPerfil": 1, "userId": userId};
      $.getJSON('php/controles/controlPerfil.php', dataEnvio,function(data){
            $("#nombreUser").html(data.nombre);
            $("#apellidosUser").html(data.apellidos);
            $("#perfil-nombre").val(data.nombre);
            $("#perfil-apellidos").val(data.apellidos);
            $("#emailUser").html(data.email);
            $("#edadUser").html(data.edad);
            document.getElementById("img-Perfil").src=data.imgPerfil;
      });
      var dataImagenes = {"fotosForPerfil": 1, "userId": userId};

      $.getJSON('php/controles/controlImagen.php', dataImagenes,function(data){
            
            var intro = '';
            for(var i = 0; i< data.length; i++){
                  var ruta = data[i].ruta+'/'+data[i].nombre;
                  intro += '<img src="'+ruta+'" class="imagenDeCiudad" name="'+data[i]["_id"]["$id"]+'">';
                  intro += '<div id="'+data[i]["_id"]["$id"]+'" class="dialogImg"> </div>';
                  //console.log(data[i]["_id"]["$id"]);
            }

            $("#fotos").html(intro);
            $(".imagenDeCiudad").click(function(){
                  var divId = $(this).attr("name");
                  var dataImgValoracion = {"verValor": 1, "userId": userId, "img":divId};
                  $.getJSON("php/controles/controlValoracionImg.php", dataImgValoracion, function(data){
                        //console.log(data);
                         var htmlInsert = "";
                        if(data){
                              htmlInsert ='<button title="me gusta" class="meGusta" id="coment-'+i+'"><span id="countPos">'+data.valorPos+'</span>';
                  	      if(data.valorDelUser){
                  	            if(data.valorDelUser.valor == 2) htmlInsert +='<img src="img/hand_pro_verde.png" >';
                  	            else htmlInsert +='<img src="img/hand_pro.png" >';
                  	      }else htmlInsert +='<img src="img/hand_pro.png" >';
                  	      htmlInsert +='</button>';
                  	      htmlInsert +='<button title="no me gusta" class="noMeGusta" id="coment-'+i+'"><span id="countNeg'+i+'">'+data.valorNeg+'</span>';
                  	      if(data.valorDelUser){
                  	            if(data.valorDelUser.valor == 1) htmlInsert +='<img src="img/hand_contra_roja.png" >';
                  	            else htmlInsert +='<img src="img/hand_contra.png" >';
                  	      }else htmlInsert +='<img src="img/hand_contra.png" >';
                  	      htmlInsert +='</button>';
                        }
            	      $("#"+divId).html( $("#"+divId).html()+htmlInsert);
                  });
                                   
                  
                  $("#"+divId).html($("#"+divId).html()+'<input type="button" class="borrarImg" value="borrar" name="'+divId+'"/><input type="button" class="reportarImg" value="reportar" name="'+divId+'"/>');
                  $('.borrarImg').click(function(){
                        borrarImagen(this);
                        $("#"+divId).dialog("close", "duration", 1000);
                  });
                  $('.reportarImg').click(function(){
                        reportarImagen(divId, userId);
                        $("#"+divId).dialog("close", "duration", 1000);
                  });
                  $("#"+divId).append($(this).clone());
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
            });
            $("#cargaAjax").dialog("close");
            $("#cargaAjax").remove();
      });
      
}

/**
 * recoge los datos del formulario del perfil y los envia para cambiar
 * 
 *---------no se validan! 
 **/ 
function modPerfil(){
       $("body").append("<div id='cargaAjax'> <img src='img/gif-load.gif'/></div>");
       $("#cargaAjax").dialog({modal:true});
      var username = $("#perfil-nombre").val();
      var apellidos = $("#perfil-apellidos").val();
      var mail =  $("#perfil-email").val();
	var dataEnvio = {"modPerfil": 1, "username": username, "apellidos":apellidos, "email": mail};
	// validacion username
      if($("#perfil-apellidos").val() == ''){
             $("#cargaAjax").dialog("close");
            $("#cargaAjax").remove();
	      alert ("el nombre no puede estar vacio");
      }else{
            $.post('php/controles/modificarPerfil.php', dataEnvio, function(data){
                  var not = JSON.parse(data);
                  alert(not.notice)
                  cargarDatos();
                  $("#info").show();
      	      $("#form-info").hide();
      	       $("#cargaAjax").dialog("close");
                  $("#cargaAjax").remove();
            });
	}
}

function subirFotos(){
      
      var file = $("#picture")[0].files[0];
	//obtenemos el nombre del archivo
	var fileName = file.name;
	//obtenemos la extensión del archivo
	var fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
	//obtenemos el tamaño del archivo
	var fileSize = file.size;
	//obtenemos el tipo de archivo image/png ejemplo
	var fileType = file.type;
	
	var userId = $("#userIdForImg").val();
	console.log(userId);
	var ciudadId = $("#buscarForImg").val();
	if ((fileSize<=200000) && (fileExtension=="jpeg") || (fileExtension=="png") || (fileExtension=="jpg")){
            //creamos un form data i añadimos el fichero
            var formData = new FormData();
            formData.append("imgPerfil", file);
            formData.append("userId", userId);
            formData.append("ciudadId", ciudadId);
            //ejecutamos ajax para que conecte con el servidor y pueda modificar
            $.ajax({
            	url: 'php/controles/modificarPerfil.php',  
            	type: 'POST',
            	data: formData,
            	cache: false,
            	contentType: false,
            	processData: false,
            	success: function(data){
                
                        //si todo va bien, vuelve a cargar los datos
                        if(data==1) cargarDatos();
                              else alert("no se ha subido");// <<<<-----No alerts loco!
                        }
                  
            });
	}else {
	      alert("La imagen es demasiado grande o no cumple el formato correcto");
	}
      
}

function borrarImagen(imagen){
      var imgId = $(imagen).attr('name');
      
      var dataEnvio = {"borrarImagen": 1, "imagenId": imgId};
      $.getJSON('php/controles/controlImagen.php', dataEnvio, function(data){
            //console.log(data);
            if(data)cargarDatos();
            //console.log(this.parentNode.nodeName);
      });
}



function reportarImagen(imagen,user){
      var imgId = imagen;
	  var userId = user;
      
      var dataEnvio = {"reportarImg": 1, "imgId": imgId, "userId": userId};
      
      $.getJSON('php/controles/controlReporte.php', dataEnvio, function(data){
            console.log(data);
            if(data) cargarDatos();
            //console.log(this.parentNode.nodeName);
      });
}

