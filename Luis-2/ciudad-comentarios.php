<?php
include("funciones.php");
$ciudad = "";
if(isset($_GET['ciudad'])){
	$ciudad = $_GET['ciudad'];
	$cursor = cargarComentCiudad($ciudad);
	$session=1;
	// falta terminaar de implemaentar la funcion.
}
?>
<html>
<head>
	<title></title>
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="cargaScript.js"></script>
</head>
<body>


<div id="comentarios-pais">
	<?php 
	foreach ($cursor as $document) {
		$cursor2 = datosUnUsuario($document["idUsu"]);?>
	<div class="coments">
		<div class="coment-up">
			<p><?php echo $cursor2["username"]; ?></p>
			<p><?php echo $document["comentario"] . "\n";?></p>
		</div>
		<div class="coment-down">
			<button title="me gusta"><img src="img/hand_pro.png" ></button>
			<button title="no me gusta"><img src="img/hand_contra.png" ></button>
			<button title="reportar abuso"	><img src="img/hand_1.png" ></button>
		</div>
	</div>
	<?php }?>
	<div>
		<form action="#" method="post">
			<textarea id="areatexto" cols="80" rows="5"></textarea>
			<!-- <input type="submit" id="kiko" value="enviar"> -->
		</form>
	</div>
</div>
</body>
</html>