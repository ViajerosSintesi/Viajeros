$(function(){
		$("#cuadro-foto").hide();
		$("#form-info").hide();
		$("#perfil-edit").click(function(){
			//actualizaPerfil();
			$("#info").hide();
			$("#form-info").show();
		});
		$("#cancelar-datos").click(function(){
			
			$("#form-info").hide();
			$("#info").show();
			
		});
		$("#subir-foto").click(function(){
			$("#cuadro-foto").show();
		});
		$("#modificar-datos").click(modPerfil);
		cargarDatos();
	      $('#foto-perfil').change(subirImgPerfil);
});
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
		var formData = {"imgPerfil":file};
	
            console.log(formData);
		$.ajax({
			url: 'php/modificarPerfil.php',  
			type: 'POST',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function(data){
			    var message = "La imagen ha subido correctamente.";
			    alert(message);
			}
		});
}
	
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

function cargarDatos(){
      var dataEnvio = {"datosPerfil": 1};
      $.getJSON('php/controlPerfil.php', dataEnvio,function(data){
            $("#nombreUser").html(data.nombre);
            $("#apellidosUser").html(data.apellidos);
            $("#perfil-nombre").val(data.nombre);
            $("#perfil-apellidos").val(data.apellidos);
            $("#emailUser").html(data.email);
            $("#edadUser").html(data.edad);
      });
}

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
