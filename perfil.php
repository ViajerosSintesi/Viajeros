<?php
      session_start();
      $user = null;
      if(!isset($_SESSION['userId'])){
            header("location:index.php");
      }else{
             if(filter_has_var(INPUT_GET,"user")){
                  $user= filter_input(INPUT_GET,"user");
            }else{
                  $user=$_SESSION['userId'];
            }
      }
      
      function comproveEmail(){
            if(filter_has_var(INPUT_GET,"user")) return 0;
            else return 1;
      }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Perfil Usuario</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.4.min.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/buscador.js"></script>
	<script src="js/perfil.js"></script>
	<script type="text/javascript">
	</script>
</head>
<body>
<input type="hidden" name="userId" value="<?php echo $user?>" id="userIdForImg"/>
<div id="wrap">
	<div id="menu">
		<button id="hide-show-menu">Barra men&uacute; <img src="img/33.png" id="ico-menu"></button>
		<div id="barra-menu">
			<input type="text" id="buscar" title="Buscar ciudad, pa&iacute;s">
			<input type="hidden" value="" id="id" />
			<ul>
				<li><a href="perfil.php">Perfil</a></li>
				<li><a href="list-pais.php">Paises</a></li>
				<li><a href="mapa.php">Mapa</a></li>
				<li><form action="php/controlLogin.php" method="post">
						<input type="submit" name="destroySession" id="destroySession" value="Cerrar session" /> 
					</form></li>
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
					<img src="img/no-imagen.jpg" id="img-Perfil">
					<form action="#" method="post" enctype="multipart/form-data" id="form-foto">
					<?php if( comproveEmail()){
				echo '<input type="file" id="foto-perfil" value="Cambiar foto perfil">';
					}
				?>
					</form>
				</div>
			</div>
			<div id="perfil-right">
			      <div id="info">
			      	<table>
			      		<?php if( comproveEmail()){ ?>
						<tr><th></th><td><div id="perfil-edit"><img src="img/edit_32px.png"></div></td></tr>
						<?php } ?>
						<tr><th>Nombre: </th><td><span id="nombreUser"></span></td></tr>
						<tr><th>Apellidos: </th><td><span id="apellidosUser"></td></tr>
						<?php if( comproveEmail()){ ?>
						<tr><th>Email: </th><td><span id="emailUser"></span></td></tr>
						<?php } ?>
						<tr><th>Fecha de nacimiento: </th><td><span id="edadUser"></span></td></tr>
						<tr><th>Pais: </th><td>Espa&ntilde;a</td></tr>
					</table>
				</div>
				<div id="form-info">
					<table>
						<tr><th><label for="">Nombre: </label></th><td><input type="text" name="nombre" id="perfil-nombre"></td></tr>
						<tr><th><label for="">Apellidos: </label></th><td><input type="text" name="apellido" id="perfil-apellidos"></td></tr>
						<tr><th><label for="">Email: </label></th><td><input type="text" name="email" id="perfil-email"></td></tr>
						<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
						<tr><td><input type="submit" name="modificar-datos" id="modificar-datos" value="Modificar datos"></td><td><input type="submit" name="cancelar" id="cancelar-datos" value="Cancelar"></td></tr>
					</table>
				</div>
			</div>
		</div>
		<div id="perfil-galeria">
			<div id="titulo">
				<h1>Fotos</h1>
					<?php if( comproveEmail()){
				echo '<div id="perfil-subir-foto"><input type="submit" id="subir-foto" value="Subir foto"></div>';
					}
				?>
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
			<?php if( comproveEmail()){ ?>
				<form action='php/controlImagen.php' method='post' enctype='multipart/form-data' id='formFotos'>
					<div id="centra-input">
						<h2>Selecciona una foto</h2>
						<input type='file' name='picture' id='picture'><br>
						<input type='text' name='ciudadId' id='buscarForImg'/><br>
						<input type='hidden' name='userId' value='$user' id='userIdForImg'/>
						<input type='submit' name='subir-pic' id='subir-pic' value='Subir foto'>
					</div>
				</form>
			<?php } ?>
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