<?php 
      session_start();
      if(isset($_GET['pais'])){
      	$pais = $_GET['pais'];
	      $userId = $_SESSION['userId'];
      }else{
            $pais = "";
	      $userId = $_SESSION['userId'];
      }
?>


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
                        var userId = "$userId";
                        var html = $("#fotos").html();
                        for(var i = 0; i <data.length; i++){
                               html += '<img src="'+data[i]["ruta"]+data[i]["nombre"]+'" class="imagenDeCiudad" name="'+data[i]["_id"]["\$id"]+'">';
                               html += '<div id="'+data[i]["_id"]["\$id"]+'" class="dialogImg"> </div>';
                        }
                  $("#fotos").html(html);
      $(".imagenDeCiudad").click(function () {
        var divId = $(this).attr("name");
        var dataImgValoracion = {
            "verValor": 1,
            "userId": "$userId",
            "img": divId
        };
        $.getJSON("php/controles/controlValoracionImg.php", dataImgValoracion, function (data) {
        
            //console.log(data);
            var htmlInsert = "";
            if (data) {
                htmlInsert = '<button title="me gusta" class="meGusta"><span id="countPos">' + data.valores.valorPos + '</span>';
                if (data.valorUsu) {
                    if (data.valorUsu.valor == 2) htmlInsert += '<img src="img/hand_pro_verde.png" >';
                    else htmlInsert += '<img src="img/hand_pro.png" >';
                } else htmlInsert += '<img src="img/hand_pro.png" >';
                htmlInsert += '</button>';
                htmlInsert += '<button title="no me gusta" class="noMeGusta"><span id="countNeg' + i + '">' + data.valores.valorNeg + '</span>';
                if (data.valorUsu) {
                    if (data.valorUsu.valor == 1) htmlInsert += '<img src="img/hand_contra_roja.png" >';
                    else htmlInsert += '<img src="img/hand_contra.png" >';
                } else htmlInsert += '<img src="img/hand_contra.png" >';
                htmlInsert += '</button>';
            }
            
            $("#" + divId).html($("#" + divId).html() + htmlInsert);
            
            $(".meGusta").click(function () {
                enviarValoracion("img", 2, userId, divId);
            });

            $(".noMeGusta").click(function () {
                enviarValoracion("img", 1, userId, divId);

            });
            $("#" + divId).html($("#" + divId).html() + '<input type="button" class="borrarImg" value="borrar" name="' + divId + '"/><input type="button" class="reportarImg" value="reportar" name="' + divId + '"/>');
            
            $('.borrarImg').click(function () {
                borrarImagen(this);
                $("#" + divId).dialog("close", "duration", 1000);
            });
            $('.reportarImg').click(function () {
                reportarImagen(divId, userId);
                  $("#"+divId).dialog("close ", "duration ", 1000);
            });
            $("#"+divId).append($(this).clone());
            console.log(this);
            $("#"+divId+" > img ").addClass("imagen - dialogo ");
            $("#"+divId).dialog({
            
                  modal: true,
                  title: "Caja con opciones ",
                  width: 720,
                  minWidth: 720,
                  maxWidth: 1080,
                  maxHeight: 1080,
                  show: "fold ",
                  hide: "scale "
            });
        });
    });
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