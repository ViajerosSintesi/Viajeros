<?php
/**
*
* index.php
* Este documento php es nuestro index, la primera pantalla que se encontrara
* los usuarios al querer entrar en la web, en la  cual se tienen que loguear
* o registrarse si aun no lo estan.
*
* @version 1.0
*
*/
      session_start();
      if(isset($_SESSION['userId'])){
            header("Location:perfil.php");
      }
      
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">

	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/alertify.default.css">
	<link rel="stylesheet" type="text/css" href="css/alertify.core.css">
	
	<script src="js/alertify.min.js"></script>
	
	<script src="js/index.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#imagen").hide();
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
	<?php
	if(filter_has_var(INPUT_GET,"ref")){
            echo "<script>alertify.alert('Te has registrado con exito!')</script>";
      }
      ?>
<div id="wrap">
	<!-- Cabecera -->
	<div id="header">
		<img src="img/logo.png">
	</div>
	<!-- Cuerpo principal -->
	<div id="contenedor">
		<div id="home-left"><img src="img/home_img1.jpg" id="imagen"></div>
		<!-- Login y registro -->
		<div id="home-right">
			<div id="form-login" >
				<fieldset>
					<legend><h2>Inicia sesi&oacute;n</h2></legend>
					<table>
						<tr><th><label for="usuario">Email: </label></th>
						<td><input type="email" id="usuario" name="usuario" value="Escribe tu email" class="text-input" required></td></tr>
						<tr><th><label for="password" >Contrase&ntilde;a: </label></th>
						<td><input type="password" id="password" name="password" required></td></tr>
						<tr><td></td><td><input type="button" name="enviar" id="boton-login" value="Iniciar sesi&oacute;n"></td></tr>
					</table>
				</fieldset>
				<p><span id="captchaDiv"></span><p>
				<p><span id="mail_incorrecto"></span><p>
				<p><span id="no_logeo"></span><p>
				<p><span id="recuperarPass" class="enlace">&#191;Olvidaste tu contrase&ntilde;a?</span></p>
				<p><span id="registro" class="enlace">&#191;Eres nuevo? Reg&iacute;strate</span></p>
			</div>
			<div id="form-registro">
				<fieldset>
					<legend><h2>Reg&iacute;stro</h2></legend>
					<p><label for="nombre">Nombre: </label><br>
						<input type="text" name="nombre" id="nombre" value="Tu nombre" class="text-input"></p>
					<p><label for="apellidos">Apellidos</label><br>
						<input type="text" name="apellidos" id="apellidos" value="Tu apellido" class="text-input"></p>
					<p><label for="email">Email: </label><br>
						<input type="email" name="email" id="email" value="Tu email" class="text-input"></p>
					<p><label for="password">Contrase&ntilde;a: </label><br>
						<input type="password" name="contra" id="contra" class="text-input"></p>
					<p><label for="password">repite la Contrase&ntilde;a: </label><br>
						<input type="password" name="repcontra" id="repcontra" class="text-input"></p>
					<p><label>Fecha de nacimiento: </label><br>
					<select name="dia" id="dia">
						<option value="0" selected="1">D&iacute;a</option>
						<?php for($i=1; $i<32;$i++){
							echo "<option value='$i'>$i</option>";
						}
						?>
					</select>
					<select name="mes" id="mes">
						<option value="0" selected="1">Mes</option>
						<option value="1">Ene</option>
						<option value="2">Feb</option>
						<option value="3">Mar</option>
						<option value="4">Abr</option>
						<option value="5">may</option>
						<option value="6">Jun</option>
						<option value="7">Jul</option>
						<option value="8">Ago</option>
						<option value="9">Sept</option>
						<option value="10">Oct</option>
						<option value="11">Nov</option>
						<option value="12">Dic</option>
					</select>
					<select name="any" id="any">
						<option value="0" selected="1">A&ntilde;o</option>
						<?php for ($i=date("Y"); $i > 1905; $i--) { 
							echo "<option value='$i'>$i</option>";
						}?>
					</select>
					</p>
					<button id="genCaptchaB"><span >Genera captcha</span></button>
					<span id="genCaptcha"></span>
					<input type="submit" name="registrarse" id="registrarse" value="Reg&iacute;strate">
				</fieldset>
				<p><span id="no_registro"><span>
				<p><span id="recuperarPass" class="enlace">&#191;Olvidaste tu contrase&ntilde;a?</span></p>
				<p><span id="login" class="enlace">Inicia sesi&oacute;n</a></p>
			</div>
		</div>
	</div>
	<!-- footer -->
	<div id="footer">
		<span><a href="#">Sobre nosotros</a></span>
		<span><a href="#">Condiciones</a></span>
		<span><a href="#">Privacidad</a></span>
		<span>&#64; 2014 Alumnos D.A.W.</span>
	</div>
</div>


</body>
</html>