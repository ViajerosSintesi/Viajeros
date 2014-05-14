<!DOCTYPE html>
<html>
<head>
	<title>Perfil Usuario</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="ajax.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#cuadro-foto").hide();
		$("#perfil-edit").click(function(){
			actualizaPerfil();
		});
		$("#subir-foto").click(function(){
			$("#cuadro-foto").show();
		});
	});
	</script>
</head>
<body>
<div id="wrap">
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
					<form action="#" method="post" enctype="multipart/form-data" id="form-foto">
					<input type="file" id="foto-perfil" value="Cambiar foto perfil">
					</form>
				</div>
			</div>
			<div id="perfil-right">
				<div id="perfil-edit"><img src="img/png/edit_32px.png"></div>
				<p><span>Nombre: </span>Pepito los palotes</p>
				<p><span>Apellidos: </span>Apellido1 Apellido2</p>
				<p><span>Email: </span>micorreo@gmail.com</p>
				<p><span>Pais: </span>Espa&ntilde;a</p>
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
		<div id="cuadro-foto">
			<form>
				<fieldset>
					<legend>Subir foto</legend>
					<input type="file" name="picture" id="picture"><br>
					<input type="submit" name="subir-pic" id="subir-pic" value="Subir foto">
				</fieldset>
			</form>
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