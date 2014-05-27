<!DOCTYPE html>
<html>
<head>
	<title>Perfil Usuario</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="ajax.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#bg-cuadro").hide();
		$("#perfil-edit").click(function(){
			actualizaPerfil();
			$.getScript("cargaScript.js");
		});
		$("#subir-foto").click(function(){
			$("#bg-cuadro").show();
			return false;
		});
		$("#cerrar-cuadro").click(function(){
			$("#bg-cuadro").hide();
		});
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
		<div id="perfil">
			<div id="titulo">
				<h1>Informaci&oacute;n</h1>
			</div>
			<div id="perfil-left" >
				<div id="img-perfil">
					<img src="img/no-imagen.jpg">
					<form action="#" method="post" enctype="multipart/form-data" id="form-foto-perfil">
					<input type="file" id="foto-perfil" value="Cambiar foto perfil">
					</form>
				</div>
			</div>
			<div id="perfil-right">
				
				<table>
					<tr><th></th><td><div id="perfil-edit"><img src="img/edit_32px.png"></div></td></tr>
					<tr><th>Nombre: </th><td>Pepito los palotes</td></tr>
					<tr><th>Apellidos: </th><td>Apellido1 Apellido2</td></tr>
					<tr><th>Email: </th><td>micorreo@gmail.com</td></tr>
					<tr><th>Pais: </th><td>Espa&ntilde;a</td></tr>
				</table>
			</div>
		</div>
		<div id="perfil-galeria">
			<div id="titulo">
				<h1>Fotos</h1>
				<div id="perfil-subir-foto"><input type="submit" id="subir-foto" value="Subir foto"></div>
			</div>
			<div id="fotos">
			<?php
			for ($i=0; $i < 8; $i++) { ?>
				<img src="img/no-imagen.jpg">
			<?php
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