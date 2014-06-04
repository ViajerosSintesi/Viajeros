<!---
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.10.4.custom.js"></script>
-->
<script type="text/javascript">
$("#bg-cuadro").hide();
$("#subir-foto").click(function(){
	$("#bg-cuadro").show();
	return false;
});
$("#cerrar-cuadro").click(function(){
	$("#bg-cuadro").hide();
});
</script>
<div id="fotos">
	<!---<div id="boton-foto"><input type="submit" id="subir-foto" value="Subir foto"></div>-->
<?php
if(isset($_GET['pais'])){
      $pais = filter_input(INPUT_GET, "pais");

      echo <<<END
            <script type="text/javascript">
                  var dataQuery = {"pais": "$pais"};
                  $.getJSON("php/controles/controlImagen.php", dataQuery, function(data){
                
                  var html = $("#fotos").html();
                  for(var i = 0; i <data.length; i++){
                         html += "<img src='"+data[i]["ruta"]+data[i]["nombre"]+"'>";
                  }
                  $("#fotos").html(html);
                  });
            </script>
END;
}else{
      for ($i=0; $i < 6; $i++) { 
      	echo "<img src='img/no-imagen.jpg'>";
      }
}
?>
</div>
<!--<div id="bg-cuadro">
	<div id="cuadro-foto">
		<div id="cerrar-cuadro"><img src="img/delete.png"></div>
		 <form action='php/controles/controlImagen.php' method='post' enctype='multipart/form-data' id='formFotos'>
					<div id="centra-input">
						<h2>Selecciona una foto</h2>
						<input type='file' name='picture' id='picture'><br>
						<h2>Selecciona una ciudad</h2>
						<input type='text' name='ciudadId' id='buscarForImg'/><br>
						<input type='hidden' name='userId' value='<?php echo $user;?>' id='userIdForImg'/>
						<input type='submit' name='subir-pic' id='subir-pic' value='Subir foto'>
					</div>
				</form>
	</div>-->
</div>