<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="js/index.js"></script>
      <!---<script src="js/ajax.js"></script>-->
	<script type="text/javascript">
	$(function(){
		$("#imagen").hide();
		/*$("#registro").click(function(){
			registro();
		});
		$("#login").click(function(){
			$(location).attr('href', "inicio.php")
		});*/
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
			<div id="form-login" >
				<fieldset>
					<legend><h2>Inicia sesi&oacute;n</h2></legend>
					<p><label for="usuario">Usuario: <input type="text" id="usuario" name="usuario"></p>
					<p><label for="password">Contrase&ntilde;a: </label><input type="password" id="password" name="password"></p>
					<input type="buton" name="enviar" id="boton-login" value="Iniciar sesi&oacute;n">
				</fieldset>
				<p><span id="recuperarPass">&#191;Olvidaste tu contrase&ntilde;a?</span></p>
				<p><span id="registro">&#191;Eres nuevo? Reg&iacute;strate</span></p>
			</div>
			
                  <div id="form-registro">
                  	<fieldset>
                  	<legend><h2>Reg&iacute;stro</h2></legend>
                  	<p><label for="nombre">Nombre: </label><br>
                  		<input type="text" name="nombre" id="nombre"></p>
                  	<p><label for="apellidos">Apellidos</label><br>
                  		<input type="text" name="apellidos" id="apellidos"></p>
                  	<p><label for="email">Email: </label><br>
                  		<input type="text" name="email" id="email"></p>
                  	<p><label for="password">Contrase&ntilde;a: </label><br>
                  		<input type="password" name="password"></p>
                  	<p><label>Fecha de nacimiento: </label><br>
                  		<select name="dia" id="dia">
                  			<option value="0" selected="1">D&iacute;a</option>
                  			<?php for($i=1; $i<32;$i++){
                  				echo "<option value='$i'>$i</option>";
                  			}
                  			?>
                  		</select>
                  		<select name="mes">
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
                  		<select name="any">
                  			<option value="0" selected="1">A&ntilde;o</option>
                  			<?php for ($i=date("Y"); $i > 1905; $i--) { 
                  				echo "<option value='$i'>$i</option>";
                  			}?>
                  		</select>
                  	</p>
                  	<input type="submit" name="registrarse" id="registrarse" value="Reg&iacute;strate">
                  	</fieldset>
                  	<p><span id="recuperarPass">&#191;Olvidaste tu contrase&ntilde;a?</span></p>
                  	<p><span id="login">Inicia sesi&oacute;n</a></p>
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