<?php
include("funciones.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mapa</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="js/ajax.js"></script>
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
		<button id="hide-show-menu">Barra men&uacute; <img src="img/33.png" id="ico-menu"></button>
		<div id="barra-menu">
			<input type="text" id="buscar" title="Buscar ciudad, pa&iacute;s">
			<ul>
				<li><a href="perfil.php">Perfil</a></li>
				<li><a href="list-pais.php">Paises</a></li>
				<li><a href="mapa.php">Mapa</a></li>
			</ul>
		</div>
	</div>
	<div id="header">
		<img src="img/logo.png">
	</div>
	<div id="contenedor">
		<div id="contenedor-mapa">
			<div id="mapa">
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