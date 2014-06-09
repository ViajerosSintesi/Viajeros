<?php
/**
* ciudad-foto.php
* En este documento se muestran todas las fotos que se haya guardado en el servidor
* de una ciudad.
*
* @version 1.0
*
*/
session_start();
if(isset($_GET['ciudad'])){
	$ciudad = $_GET['ciudad'];
      $userId = $_SESSION['userId'];
}else{
      $ciudad = "";
      $userId = $_SESSION['userId'];
}
?>
<script src="js/comun.js"></script>
<div id="fotos">
	<div id="boton-foto"><input type="submit" id="subir-foto" value="Subir foto"></div>
<script type="text/javascript">

/*$("#bg-cuadro").hide();
$("#subir-foto").click(function(){
	$("#bg-cuadro").show();
	return false;
});
$(".cerrar-cuadro").click(function(){
	$("#bg-cuadro").hide();
});*/
 $("#formfotos").submit(subirFotos);

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
</script>
<div id="foto">

<?php
if(isset($_GET['ciudad'])){
      $ciudadId= filter_input(INPUT_GET, "ciudad");

      echo <<<END
     <script type="text/javascript">
            var userId = "$userId";
                  var dataImagenes = {"ciudadId": "$ciudadId","fotosForCiudad":1};
 $.getJSON('php/controles/controlImagen.php', dataImagenes,function(data){
            
            var intro = '';
            for(var i = 0; i< data.length; i++){
                  var ruta = data[i].ruta+'/'+data[i].nombre;
                  intro += '<img src="'+ruta+'" class="imagenDeCiudad" data-user="'+data[i]["usuario"]+'" name="'+data[i]["_id"]["\$id"]+'">';
                  intro += '<div id="'+data[i]["_id"]["\$id"]+'" class="dialogImg"> </div>';
                  //console.log(data[i]["_id"]["\$id"]);
            }

            $("#foto").html(intro);
            $(".imagenDeCiudad").click(function(){
                   var divId = $(this).attr("name");
                   var borra = 0;

                   if(userId == $(this).attr("data-user")) borra =1;
                  imgDialog(userId, divId, borra);
            });
            $("#cargaAjax").dialog("close");
            $("#cargaAjax").remove();
      });
            </script>
</script>
END;
}else{
      for ($i=0; $i < 6; $i++) { 
      	echo "<img src='img/no-imagen.jpg'>";
      }
}
?>
</div>
</div>
<div id="bg-cuadro">
	<div id="cuadro-foto">
		<div class="cerrar-cuadro"><img src="img/75.png"></div>
		<form action='php/controles/controlImagen.php' method='post' enctype='multipart/form-data' id='formFotos'>
			<div id="centra-input">
				<h2>Selecciona una foto</h2>
				<input type='file' name='picture' id='picture'><br>
				<input type='hidden' name='ciudadId' value="<?php echo $ciudad;?>" id='buscarForImg'/><br>
				<input type='hidden' name='userId' value='<?php echo $userId;?>' id='userIdForImg'/>
				<input type='submit' name='subir-pic' id='subir-pic' value='Subir foto'>
			</div>
		</form>
	</div>
</div>

