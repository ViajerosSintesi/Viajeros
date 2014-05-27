<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="ajax.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#imagen").hide();
		$("#registro").click(function(){
			registro();
		});
		$("#login").click(function(){
			$(location).attr('href', "inicio.php")
		});
	});
	
	function runEffect() {
		var selectedEffect = "explode";
		var options = {};
		$( "#imagen" ).show( selectedEffect, options, 1000);
	};
	window.onload=runEffect;
	
	</script>
</head>
<body>
<div id="wrap">
	<div id="header">
		<img src="img/logo.png">
	</div>
	<div id="contenedor">
		<div id="home-left"><img src="img/home_img1.jpg" id="imagen"></div>
		<div id="home-right">
			<form action="#" method="post" name="form-login">
				<fieldset>
					<legend><h2>Inicia sesi&oacute;n</h2></legend>
					<p><label for="usuario">Usuario: <input type="text" id="usuario" name="usuario"></p>
					<p><label for="password">Contrase&ntilde;a: </label><input type="password" id="password" name="password"></p>
					<input type="submit" name="enviar" id="boton-login" value="Iniciar sesi&oacute;n">
				</fieldset>
				<p><span id="recuperarPass">&#191;Olvidaste tu contrase&ntilde;a?</span></p>
				<p><span id="registro">&#191;Eres nuevo? Reg&iacute;strate</span></p>
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