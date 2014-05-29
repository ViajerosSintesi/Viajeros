<?php
include("../funciones.php");
if(isset($_GET['pais'])){
	$pais = $_GET['pais'];
}
?>
<html>
<head>
	<title></title>
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="js/cargaScript.js"></script>
</head>
<body>


<div id="comentarios-pais">
	<?php 
	$cursor = cargarComentPais($pais);
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