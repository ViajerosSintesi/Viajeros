<?php 
      session_start();
      if(isset($_GET['ciudad'])){
      	$ciudad = $_GET['ciudad'];
	      $userId = $_SESSION['userId'];
      }else{
            $ciudad = "";
	      $userId = $_SESSION['userId'];
      }
?>
<!--
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.10.4.custom.js"></script>
-->

<div id="fotos">
	<div id="boton-foto"><input type="submit" id="subir-foto" value="Subir foto"></div>
<script type="text/javascript">

$("#bg-cuadro").hide();
$("#subir-foto").click(function(){
	$("#bg-cuadro").show();
	return false;
});
$("#cerrar-cuadro").click(function(){
	$("#bg-cuadro").hide();
});
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
                  var dataImagenes = {"ciudad": "$ciudad"};
 $.getJSON('php/controles/controlImagen.php', dataImagenes,function(data){
            
            var intro = '';
            for(var i = 0; i< data.length; i++){
                  var ruta = data[i].ruta+'/'+data[i].nombre;
                  intro += '<img src="'+ruta+'" class="imagenDeCiudad" name="'+data[i]["_id"]["\$id"]+'">';
                  intro += '<div id="'+data[i]["_id"]["\$id"]+'" class="dialogImg"> </div>';
                  //console.log(data[i]["_id"]["\$id"]);
            }

            $("#fotos").html(intro);
            $(".imagenDeCiudad").click(function(){
                  var divId = $(this).attr("name");
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
                  	      htmlInsert +='<button title="no me gusta" class="noMeGusta"><span id="countNeg'+i+'">'+data.valores.valorNeg+'</span>';
                  	      if(data.valorUsu){
                  	            if(data.valorUsu.valor == 1) htmlInsert +='<img src="img/hand_contra_roja.png" >';
                  	            else htmlInsert +='<img src="img/hand_contra.png" >';
                  	      }else htmlInsert +='<img src="img/hand_contra.png" >';
                  	      htmlInsert +='</button>';
                        }
            	      $("#"+divId).html( $("#"+divId).html()+htmlInsert);
                        $(".meGusta").click(function(){
                             
                              enviarValoracion("img", 2, userId, divId);
                              
                        });
                        
                        $(".noMeGusta").click(function(){
                              enviarValoracion("img", 1, userId, divId);
                              
                        });
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
		<div id="cerrar-cuadro"><img src="img/delete.png"></div>
		<form action='php/controles/controlImagen.php' method='post' enctype='multipart/form-data' id='formFotos'>
			<div id="centra-input">
				<h2>Selecciona una foto</h2>
				<input type='file' name='picture' id='picture'><br>
				
				<input type='hidden' name='ciudadId' value="<?php echo $ciudad;?>" id='buscarForImg'/><br>
				<input type='hidden' name='userId' value='<?php echo $user;?>' id='userIdForImg'/>
				<input type='submit' name='subir-pic' id='subir-pic' value='Subir foto'>
			</div>
		</form>
	</div>
</div>

