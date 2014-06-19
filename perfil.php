<?php
/**
*
* perfil.php
* Este documento php muestra toda la información del usuario, la cual
* esta dividida en tres partes: la información personal, fotos y por último
* la de ubicación.
*
*/
session_start();
$user = null;
if(!isset($_SESSION['userId'])){
	header("location:index.php");
}else{
      
	if(filter_has_var(INPUT_POST,"user")){
		$user= filter_input(INPUT_POST,"user");
		require_once("php/clases/UserClass.php");

	      $usuario = new User();
	      $usuario->setId(base64_decode($user));
	      $usuario->cogeValoresSegunId();
	      if($usuario->getPrivado() == 1){
	            header("location:perfil.php?ref=2");
	      }

	}else{
	      
		$user=$_SESSION['userId'];
		/*require_once("php/clases/UserClass.php");
	      $usuario = new User();
	      $usuario->setId($user);
	      $usuario->cogeValoresSegunId();*/
	}
}

function comproveEmail(){
	if(filter_has_var(INPUT_POST,"user") == $_SESSION['userId']) return 0;
	else return 1;
}
include("php/funciones.php");
$coor = lugaresUsuario($user);
$coor=json_encode($coor["lugares"]);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Perfil Usuario</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.4.min.css">
	<link rel="stylesheet" type="text/css" href="css/alertify.default.css">
	<link rel="stylesheet" type="text/css" href="css/alertify.core.css">
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="js/alertify.min.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/buscador.js"></script>
	<script src="js/comun.js"></script>
	<script src="js/perfil.Ext.js"></script>

	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
</head>
<body>
<?php
if(filter_has_var(INPUT_GET,"ref"))
      if(filter_input(INPUT_GET,"ref") == 2)
            echo "<script>alertify.alert('El perfil que intentas acceder es privado');</script>";
?>
<input type="hidden" name="userId" value="<?php echo $user?>" id="userIdForImg"/>
<div id="wrap">
	<!-- Barra de menu -->
	<div id="menu">
		<button id="hide-show-menu" title="Ocultar/mostrar barra de men&uacute;">Barra men&uacute; <img src="img/33.png" id="ico-menu"></button>
		<div id="barra-menu">
			<input type="text" id="buscar" title="Buscar ciudad, pa&iacute;s">
			<input type="hidden" value="" id="id" />
			<ul>
			      <li><a href="#" id="mensajes" title="mensajes">mensajes</a></li>
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
	<!-- fin barra menu -->
	<div id="mnsjDiv"></div>
	<!-- Cabecera -->
	<div id="header">
		<img src="img/logo.png">
	</div>
	<!-- Cuerpo principal -->
	<div id="contenedor">
		<!-- Parte de informacion personal -->
		<?php if(!comproveEmail()){ ?>
		      <button id="enviaMensaje"> Enviale un mensaje<button/>
		<?php } ?>
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
						<tr><th></th><td><div id="perfil-edit"><img src="img/152.png" title="Editar informaci&oacute;n"></div></td></tr>
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
						<tr><th><label for="">Email: </label></th><td><input type="email" name="email" id="perfil-email"></td></tr>
						<tr><th><label for="">Password: </label></th><td><input type="password" name="password" id="perfil-password"></td></tr>
						<tr><th><label for="">respite el password: </label></th><td><input type="password" name="repassword" id="perfil-repassword"></td></tr>
						<tr><th><label for="">Privacidad: </label></th><td><select id="privacidad" name="privacidad">
						<option value="0">Publico</option>
					      <option value="1">Privado</option>
					      </option>
					      </td></tr>
						<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
						<p><span id="no_modifico"><span>
						<tr><td><input type="submit" name="modificar-datos" id="modificar-datos" value="Modificar datos"></td><td><input type="submit" name="cancelar" id="cancelar-datos" value="Cancelar"></td></tr>
					</table>
				</div>
			</div>
		</div>
		<!-- Galeria de imagenes del usuario -->
		<div id="perfil-galeria">
			<div id="titulo">
				<h1>Fotos</h1>
					<?php if( comproveEmail()){
				echo '<div id="perfil-subir-foto"><input type="submit" id="subir-foto" value="Subir foto" title="Subir foto"></div>';
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
		<!-- Capa oculta que contiene el formulario para subir imagenes y para mostrar la geololocalizacion -->
		<div id="bg-cuadro">
			<!-- subir foto -->
			<div id="cuadro-foto">
				<div class="cerrar-cuadro"><img src="img/75.png"></div>
			<?php if( comproveEmail()){ ?>
				    <form action='php/controles/controlImagen.php' method='post' enctype='multipart/form-data' id='formFotos'>
					<div id="centra-input">
						<h2>Selecciona una foto</h2>
						<input type='file' name='picture' id='picture'><br>
						<h2>Selecciona una ciudad</h2>
						<input type='text' name='ciudadId' id='buscarForImg' required/><br>
						<input type='hidden' name='userId' value='<?php echo $user;?>' id='userIdForImg'/>
						<input type='submit' name='subir-pic' id='subir-pic' value='Subir foto'>
					</div>
				</form>
			<?php } ?>
			</div>
			<!-- ubicacion -->
			<div id="mapa-ubicacion">
				<div class="cerrar-cuadro"><img src="img/75.png"></div>
			</div>
		</div>
		<!-- Mapa con las ubicaciones del usuario -->
		<div id="perfil-lugares">
			<div id="titulo">
				<h1>Lugares</h1>
			</div>
			<div id="map-div"><?php echo $coor?></div>
		</div>
		<!-- Codigo javascript para cargar el mapa -->
		<script>
		var coor = <?php echo $coor?>;
		var infowindow = new google.maps.InfoWindow();
		function initialize() {
			var myLatlng = new google.maps.LatLng(36.4613218,-1.2081181,4);
			var mapOptions = {
				zoom: 2,
				center: myLatlng
			}
			var map = new google.maps.Map(document.getElementById('map-div'), mapOptions);

			for (var i = 0; i < coor.length; i++) {
			      
				var c1 = coor[i].coor.split(",",2);
				var contenido = coor[i].direc;
				var myLatlng2 = new google.maps.LatLng(c1[0], c1[1]);
				var marker = new google.maps.Marker({
					position: myLatlng2,
					map: map
				});
				(function(marker, contenido){                       
					google.maps.event.addListener(marker, 'click', function(){
						infowindow.setContent(contenido);
						infowindow.open(map, marker);
					});
				})(marker,contenido);
			};
		}
		google.maps.event.addDomListener(window, 'load', initialize);
		</script>
	</div>
	<!-- fin cuerpo -->
	<!-- footer -->
	<div id="footer">
		<span><a href="#">Sobre nosotros</a></span>
		<span><a href="#">Condiciones</a></span>
		<span><a href="#">Privacidad</a></span>
		<span>&#64; 2014 Alumnos D.A.W.</span>
	</div>
	<!-- fin footer -->
</div>
</body>
</html>