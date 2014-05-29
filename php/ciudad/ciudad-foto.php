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
</script>
<div id="foto">

<?php
if(isset($_GET['ciudad'])){
      $ciudadId= filter_input(INPUT_GET, "ciudad");

      echo <<<END
            <script type="text/javascript">
                  var dataQuery = {"fotosForCiudad":"1", "ciudadId":"$ciudadId"};
                  var htmli = $("#fotos").html();
                  console.log("hola");
                  $.getJSON("php/controles/controlImagen.php", dataQuery, function(data){
                       
                        for(var i = 0; i <data.length; i++){
                               htmli += "<img src='"+data[i]["ruta"]+data[i]["nombre"]+"'>";
                        }
                        $("#foto").html(htmli);
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
</div>
<div id="bg-cuadro">
	<div id="cuadro-foto">
		<div id="cerrar-cuadro"><img src="img/delete.png"></div>
		<form action="#" method="post" id="form-fotos">
			<div id="centra-input">
			<h2>Selecciona una foto</h2>
			<p><input type="file" name="picture" id="picture"><br></p>
			<input type="submit" name="subir-pic" id="subir-pic" value="Subir foto">
			</div>
		</form>
	</div>
</div>

