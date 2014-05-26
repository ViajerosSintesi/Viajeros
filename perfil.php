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
	<div id="header">
		<img src="img/logo.png">
	      
	</div>
	<div id="contenedor">
	      <div>
	            <input type="text" id="buscar"/>
	      </div>
	      <form action="php/controlLogin.php" method="post">
	      
	            <input type="submit" name="destroySession" value="cerrar session" /> 
		</form>
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
				<?php if( comproveEmail()){
				echo '<div id="perfil-edit"><img src="img/png/edit_32px.png"></div>';
				}?>
				<p><span>Nombre: </span><span id="nombreUser"></span></p>
				<p><span>Apellidos: </span><span id="apellidosUser"></span></p>
				<?php if( comproveEmail()){
				      	echo '<p><span>Email: </span><span id="emailUser"></span></p>';
				}
			      ?>
				<p><span>Pais: </span><span id="pais">Espa&ntilde;a</span></p>
				<p><span>Fecha de nacimiento: </span><span id="edadUser"></span></p>
				</div>
				<div id="form-info">
	                        <p><label for="">Nombre: </label><input type="text" name="nombre" id="perfil-nombre"></p>
                        	<p><label for="">Apellidos: </label><input type="text" name="apellido" id="perfil-apellidos"></p>
                        	<!--<p><label for="">Email: </label><input type="text" name="email" id="perfil-email"></p>-->
                        	<input type="button" name="modificar" id="modificar-datos" value="Modificar datos">
                        	<input type="button" name="cancelar" id="cancelar-datos" value="Cancelar">
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
		<div id="cuadro-foto">
		<?php if( comproveEmail()){
				
	          echo "
			<form action='php/controlImagen.php' method='post' enctype='multipart/form-data' id='formFotos'>
				<fieldset>
					<legend>Subir foto</legend>
					<input type='file' name='picture' id='picture'><br>
					<input type='text' name='ciudadId' id='buscarForImg'/><br>
					<input type='hidden' name='userId' value='$user' id='userIdForImg'/>
					<input type='submit' name='subir-pic' id='subir-pic' value='Subir foto'>
				</fieldset>
			</form>";
		}
			?>
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