<form action="php/controlRegistro.php" method="post" id="form-registro">
	<fieldset>
	<legend><h2>Reg&iacute;stro</h2></legend>
	<p><label for="nombre">Nombre: </label><br>
		<input type="text" name="nombre" id="nombre"></p>
	<p><label for="apellidos">Apellidos</label><br>
		<input type="text" name="apellidos" id="apellidos"></p>
	<p><label for="email">Email: </label><br>
		<input type="text" name="email" id="email"></p>
	<p><label for="password">Contrase&ntilde;a: </label><br>
		<input type="text" name="password"></p>
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
	<p><a href="index.html"><span id="login">Inicia sesi&oacute;n</span></a></p>
</form>