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
		$("#cuadro-foto").hide();
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
			$("#cuadro-foto").show();
		});
		//al aceptar los cambios, modificas la informacion
		$("#modificar-datos").click(modPerfil);
		//si se elige foto, la sube
	      $('#foto-perfil').change(subirImgPerfil);

            //reutilizable, es para buscar. la funcion buscador esta en js/buscador.js
            $("#buscar" ).autocomplete({
                  source: buscador,
                  select: function(){
                        window.location="http://google.es";
                  }
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
		
		
		if (fileSize<=200000){
		
		
		//creamos un form data i añadimos el fichero
	      var formData = new FormData();
	      formData.append("imgPerfil", file);
            
        //ejecutamos ajax para que conecte con el servidor y pueda modificar
		$.ajax({
			url: 'php/modificarPerfil.php',  
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
		}
		
		else {
		alert("la imagen es demasiado grande");
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
      var dataEnvio = {"datosPerfil": 1};
      $.getJSON('php/controlPerfil.php', dataEnvio,function(data){
            $("#nombreUser").html(data.nombre);
            $("#apellidosUser").html(data.apellidos);
            $("#perfil-nombre").val(data.nombre);
            $("#perfil-apellidos").val(data.apellidos);
            $("#emailUser").html(data.email);
            $("#edadUser").html(data.edad);
            document.getElementById("img-Perfil").src=data.imgPerfil;
      });
}

/**
 * recoge los datos del formulario del perfil y los envia para cambiar
 * 
 *---------no se validan! 
 **/ 
function modPerfil(){
      var username = $("#perfil-nombre").val();
      var apellidos = $("#perfil-apellidos").val();
      var dataEnvio = {"modPerfil": 1, "username": username, "apellidos":apellidos};
      $.post('php/modificarPerfil.php', dataEnvio, function(data){
            var not = JSON.parse(data);
            alert(not.notice)
            cargarDatos();
            $("#info").show();
	      $("#form-info").hide();
      });
}
