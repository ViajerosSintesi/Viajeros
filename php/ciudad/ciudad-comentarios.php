<?php
include("../funciones.php");
$ciudad = "";
if(isset($_GET['ciudad'])){
	$ciudad = $_GET['ciudad'];
	$cursor = cargarComentCiudad($ciudad);
	$session=1;
	// falta terminaar de implemaentar la funcion.
}
?>
<!doctype html>
<head>
	<title></title>
	<!--<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>-->
	
	<script src="js/cargaScript.js"></script>
	<script src="js/valoracion.js"></script>
	
	<script type="text/javascript">
	      $(function(){
	            $(".meGusta").click(function(){
	                  
	                  var id=$(this).attr("id");
	                  var numComent = id[id.length-1];
	                  //console.log(numComent);
	                  var idUsu= $("#idUsu"+numComent).val();
	                  var idComment= $("#idComent"+numComent).val();
	                  enviarValoracion("comment", 2, idUsu, idComment);
	            });
	            $(".noMeGusta").click(function(){
	                  var id=$(this).attr("id");
	                  var numComent = id[id.length-1];
	                  //console.log(numComent);
	                  var idUsu= $("#idUsu"+numComent).val();
	                  var idComment= $("#idComent"+numComent).val();
	                  enviarValoracion("comment", 1, idUsu, idComment);
	                  
	            });
	      });
	      
	</script>
</head>
<body>


<div id="comentarios-pais">
	<?php 
	$i =0;
	foreach ($cursor as $document) {
		$cursor2 = datosUnUsuario($document["idUsu"]);?>
	<div class="coments">
		<div class="coment-up">
			<p><?php echo $cursor2["username"]; ?></p>
			<p><?php echo $document["comentario"] . "\n";?></p>
			<input type="hidden" id="idUsu<?php echo $i;?>" value="<?php echo $document["idUsu"];?>"/>
			<input type="hidden" id="idComent<?php echo $i;?>" value="<?php echo $document["_id"];?>"/>

		</div>
		<div class="coment-down">
			<button title="me gusta" class="meGusta" id="coment-<?php echo $i;?>"><img src="img/hand_pro.png" ></button>
			<button title="no me gusta" class="noMeGusta" id="coment-<?php echo $i;?>"><img src="img/hand_contra.png" ></button>
			<button title="reportar abuso"><img src="img/hand_1.png" ></button>
		</div>
	</div>
	<?php $i++;}?>
	<div>
		<form action="#" method="post">
			<textarea id="areatexto" cols="80" rows="5"></textarea>
			<!-- <input type="submit" id="kiko" value="enviar"> -->
		</form>
	</div>
</div>
</body>
</html>