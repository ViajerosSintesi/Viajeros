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
            /*//esconde el cuadro para subir imagenes
            $("#bg-cuadro").hide();
            $("#cuadro-foto").hide();
            $("#mapa-ubicacion").hide();*/
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
            /*//si se hace click al boton de subir imagenes, aparece el cuadro
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

            });*/
            
            //al aceptar los cambios, modificas la informacion
            $("#modificar-datos").click(modPerfil);
            //si se elige foto, la sube
            $('#foto-perfil').change(subirImgPerfil);

            /*//reutilizable, es para buscar. la funcion buscador esta en js/buscador.js
            $("#buscar" ).autocomplete({
                  source: buscador,
                  select: function(){
                        var res = document.getElementById("id").value;
                        window.location=res;
                  }
            });*/
            $("#buscarForImg" ).autocomplete({
                  source: buscador
            });
            
            $("#formfotos").submit(subirFotos);
            /*//Menu
            $("#hide-show-menu").click(function(){
                  $("#barra-menu").toggle("slow",function(){
                        var src = ($("#ico-menu").attr('src') === 'img/33.png')
                        ? 'img/32.png'
                        : 'img/33.png';
                        $("#ico-menu").attr('src', src);
                  });
            });*/
            $("#enviaMensaje").click(function(){
                  alertify.prompt("Dejale un mensaje: ", function(e, str){
                        if(e){
                              var userId = $("#userIdForImg").val();
                              var data = new Date().toString();
                              var dataEnvio = {"userReceptor": userId, "texto":str, "fecha": data, "enviarMnsj":1};
                              
                              $.getJSON("php/controles/controlMensajes.php", dataEnvio, function(data){
                                    if(data)
                                          alertify.success("enviado correctamente");
                                    else
                                          alertify.error("No se ha podido enviar :(");
                              }); 
                        }
                  });   
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
                  	    if(data==1){ 
                  	          alertify.success("Subido perfectamente!");
                  	          cargarDatos();}
                  	    else alertify.error("no se ha subido");// <<<<-----No alerts loco!
                  	}
                  });
		}else {
		      alertify.error("La imagen es demasiado grande o no cumple el formato correcto");
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
       //$("body").append("<div id='cargaAjax'> <img src='img/gif-load.gif'/></div>");
       //$("#cargaAjax").dialog({modal:true});
      var userId = $("#userIdForImg").val();
      var dataEnvio = {"datosPerfil": 1, "userId": userId};
      $.getJSON('php/controles/controlPerfil.php', dataEnvio,function(data){
            $("#nombreUser").html(data.nombre);
            $("#apellidosUser").html(data.apellidos);
            $("#perfil-nombre").val(data.nombre);
            $("#perfil-apellidos").val(data.apellidos);
            $("#emailUser").html(data.email);
            $("#edadUser").html(data.edad);
            if(data.imgPerfil!=null)
                  document.getElementById("img-Perfil").src=data.imgPerfil;
      });
      var dataImagenes = {"fotosForPerfil": 1, "userId": userId};

      $.getJSON('php/controles/controlImagen.php', dataImagenes,function(data){
            
            var intro = '';
            for(var i = 0; i< data.length; i++){
                  var ruta = data[i].ruta+'/'+data[i].nombre;
                  intro += '<img src="'+ruta+'" class="imagenDeCiudad" data-user="'+data[i]["usuario"]+'" name="'+data[i]["_id"]["$id"]+'">';
                  intro += '<div id="'+data[i]["_id"]["$id"]+'" class="dialogImg"> </div>';
                  //console.log(data[i]["_id"]["$id"]);
            }

            $("#fotos").html(intro);
            $(".imagenDeCiudad").click(function(){
                    var divId = $(this).attr("name");
                   var borra = 0;

                  if(userId == $(this).attr("data-user")) borra =1;
                  imgDialog(userId, divId, borra);
            });
            
            //$("#cargaAjax").dialog("close");
            //$("#cargaAjax").remove();
      });
      
}



/**
 * recoge los datos del formulario del perfil y los envia para cambiar
 * 
 *---------no se validan! 
 **/ 
 
 
function modPerfil(){
       $("body").append("<div id='cargaAjax'> <img src='img/gif-load.gif'/></div>");
       //$("#cargaAjax").dialog({modal:true});
      var username = $("#perfil-nombre").val();
      var apellidos = $("#perfil-apellidos").val();
      var mail =  $("#perfil-email").val();
	var pass =  $("#perfil-password").val();
	var privacidad =  $("#privacidad").val();
	var dataEnvio = {"modPerfil": 1, "username": username, "apellidos":apellidos, "email": mail, "password": pass, "privacidad": privacidad};
		// validacion username
      /*if(($("#perfil-nombre").val() == '')||(pass.length<=4)){
            $("#cargaAjax").dialog("close");
            $("#cargaAjax").remove();
	      document.getElementById("no_modifico").innerHTML="El campo nombre no puede estar vacio y el password debe tener almenos 5 digitos";
      }else{*/
            $.post('php/controles/modificarPerfil.php', dataEnvio, function(data){
                  var not = JSON.parse(data);
                  if(not.notice)
                        alertify.success('Datos modificados correctamente!');
                  else 
                        alertify.error(':( Ha habido algun problema al actualizar los datos');
                  cargarDatos();
                  $("#info").show();
      	      $("#form-info").hide();
      	      //$("#cargaAjax").dialog("close");
                  //$("#cargaAjax").remove();
            });
	//}
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
	if ((fileSize<=50000) && (fileExtension=="jpeg") || (fileExtension=="png") || (fileExtension=="jpg")){
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
                              else alertify.error("no se ha subido");// <<<<-----No alerts loco!
                        }
                  
            });
	}else {
	      alertify.alert("La imagen es demasiado grande o no cumple el formato correcto");
	}
      
}

