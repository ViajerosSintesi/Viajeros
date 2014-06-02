<?php
include("php/funciones.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Lista de Paises</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/comun.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#hide-show-menu").click(function(){
			$("#barra-menu").toggle("slow",function(){
				var src = ($("#ico-menu").attr('src') === 'img/33.png')
            	? 'img/32.png'
            	: 'img/33.png';
         		$("#ico-menu").attr('src', src);
			});
		});
	});
	</script>
</head>
<body>
<div id="wrap">
	<div id="menu">
		<button id="hide-show-menu" title="Ocultar/mostrar barra de men&uacute;">Barra men&uacute; <img src="img/33.png" id="ico-menu"></button>
		<div id="barra-menu">
			<input type="text" id="buscar" title="Buscar ciudad, pa&iacute;s">
			<input type="hidden" value="" id="id" />
			<ul>
				<li><a href="#" id="miUbicacion" title="Obterner ubicaci&oacute;n"><img src="img/161.png"></a></li>
				<li><a href="perfil.php" title="Ir a perfil">Perfil</a></li>
				<li><a href="list-pais.php" title="Lista de paises">Paises</a></li>
				<li><a href="mapa.php" title="Muestra el mapa">Mapa</a></li>
				<li><form action="php/controles/controlLogin.php" method="post">
						<input type="submit" name="destroySession" id="destroySession" value="Cerrar session" title="Cambiar foto de perfil" /> 
					</form></li>
			</ul>
		</div>
	</div>
	<div id="header">
		<img src="img/logo.png">
	</div>
	<div id="contenedor">
		<div id="contenedor-paises">
			<div class="list-paises">
			<?php
			$cursor = listPaises();
			$var = 'A';
			echo "<h2>".$var."</h2>";
			echo "<ul>";
			foreach ($cursor as $document){
				if($var == $document['pais'][0]){
					echo "<li><a href='pais.php?pais=".$document['_id']."'>".$document['pais']."</a></li>";
				}else{
					echo "</ul>";
					echo "<hr><h2>".$document['pais'][0]."</h2>";
					echo "<ul>";
					echo "<li><a href='pais.php?pais=".$document['_id']."'>".$document['pais']."</a></li>";
					$var = $document['pais'][0];
				}
			}
			?>
			</div>
		</div>
	</div>
	<div id="footer">
		<span><a href="#">Sobre nosotros</a></span>
		<span><a href="#">Condiciones</a></span>
		<span><a href="#">Privacidad</a></span>
		<span>&#64; 2014 Alumnos D.A.W.</span>
	</div>
</div>
</body>
</html>