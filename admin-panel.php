<?php
/**
*
* admin-panel.php
* Este documento php muestra las opciones unicas para el administrador
* de la web.
*
*/
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
include("php/funciones.php");
$coor = lugaresUsuario($user);
$coor=json_encode($coor["lugares"]);
/**
* Estas acciones se ejecutan despues de verificar con jquery que los campos
* esten debidamente rellenados, una vez pasan la comprobación, se ejecuta este
* código php que llama a unas funciones para realizar la inserción.
*/
?>
<!DOCTYPE html>
<html>
<head>
	<title>Perfil Usuario</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.4.min.css">
	<script src="js/jquery-2.1.1.min.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/buscador.js"></script>
	<script src="js/comun.js"></script>
	<script src="js/perfil.js"></script>
	<script src="js/admin.js"></script>
		<link rel="stylesheet" type="text/css" href="css/alertify.default.css">
	<link rel="stylesheet" type="text/css" href="css/alertify.core.css">
	
	<script src="js/alertify.min.js"></script>
	
	<script src="js/index.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
</head>
<body>
<?php
if(@$_POST['guardarPais']){
	$coordenadasPais = str_replace("(", "", $_POST['coordenadasPais']);
	$coordenadasPais = str_replace(")", "", $coordenadasPais);
      if(insertarPais($_POST['nombrePais'], $_POST['infoPais'], $coordenadasPais))
	       echo "<script>alertify.success('Pais Insertado :)')</script>";
	 else
	      echo "<script>alertify.error('ya existe :(')</script>";
}
if(@$_POST['guardarCiudad']){
	$coordenadasCiudad = str_replace("(", "", $_POST['coordenadasCiudad']);
	$coordenadasCiudad = str_replace(")", "", $coordenadasCiudad);
	$pais = $_POST['pertecePais'];
	$pais = explode("|", $pais);
	//var_dump($pais);
	$idPais = $pais[0];
	$nomPais = $pais[1];
	if(insertarCiudad($_POST['nombreCiudad'], $_POST['infoCiudad'], $coordenadasCiudad, $idPais, $nomPais))
	      echo "<script>alertify.success('Pais Insertado :)')</script>";
	 else
	      echo "<script>alertify.error('ya existe :(')</script>";
	 
}
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
	<!-- Cabecera -->
	<div id="header">
		<img src="img/logo.png">
	</div>
	<!-- Cuerpo principal -->
	<div id="contenedor">
		<!-- Parte de informacion personal -->
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
						<tr><th><label for="">Email: </label></th><td><input type="text" name="email" id="perfil-email"></td></tr>
						<tr><th><label for="">Password: </label></th><td><input type="password" name="password" id="perfil-password"></td></tr>
						<tr><td>&nbsp;</td></tr><tr><td>&nbsp;</td></tr>
						<p><span id="no_modifico"><span>
						<tr><td><input type="submit" name="modificar-datos" id="modificar-datos" value="Modificar datos"></td><td><input type="submit" name="cancelar" id="cancelar-datos" value="Cancelar"></td></tr>
					</table>
				</div>
			</div>
		</div>
		<div class="nuevoLugar">
			<div id="titulo"><h1>Nuevo Pa&iacute;s</h1></div>
			<table>
				<tbody>
					<form action="#" method="post" name="formNuevoPais" id="formNuevoPais">
					<tr><th>Nombre:</th></tr>
					<tr><td><input type="text" name="nombrePais" id="nombrePais"></td></tr>
					<tr><th>Informaci&oacute;n:</th></tr>
					<tr><td><textarea cols="35" rows="15" name="infoPais" id="infoPais"></textarea></td></tr>
					<tr><th>Ubicacion:</th></tr>
					<tr><td><input class="autocomplete" type="text"></td></tr>
					<tr><td>
						<input type="text" name="coordenadasPais" id="coordenadasPais">
						<div class="map_canvas"></div>
					</td></tr>
					<tr><td><input type="submit" value="Guardar" name="guardarPais" id="guardarPais"></td></tr>
					</form>
				</tbody>
			</table>
			
		</div>
		<div class="nuevoLugar">
			<div id="titulo"><h1>Nueva Ciudad</h1></div>
			<table>
				<tbody>
					<form action="#" method="post" name="formNuevaCiudad" id="formNuevaCiudad">
					<tr><th>Nombre:</th></tr>
					<tr><td><input type="text" name="nombreCiudad" id="nombreCiudad"></td></tr>
					<tr><th>Informaci&oacute;n:</th></tr>
					<tr><td><textarea cols="35" rows="15" name="infoCiudad" id="infoCiudad"></textarea></td></tr>
					<tr><th>Pais:</th></tr>
					<tr><td>
						<select name="pertecePais" id="pertenecePais">
							<option value="">Selecciona el pa&iacute;s de origen</optgroup>
						<?php 
						$cursor = listPaises();
						foreach ($cursor as $document) {
							echo "<option value='".$document['_id']."|".$document['pais']."'>".$document['pais']."</option>";
						}
						?>
						</select>
					</td></tr>
					<tr><th>Ubicacion:</th></tr>
					<tr><td><input class="autocomplete" type="text"></td></tr>
					<tr><td>
						<input type="text" name="coordenadasCiudad" id="coordenadasCiudad">
						<div class="map_canvas"></div>
					</td></tr>
					<tr><td><input type="submit" value="Guardar" name="guardarCiudad" id="guardarCiudad"></td></tr>
					</form>
				</tbody>
			</table>
			<script type="text/javascript">
				/**
				* Funciones javascript para la implementación del mapa.
				*/
				// declaracion de variables.
				var map, places, iw;
				var markers = [];
				var autocompleteP, autocompleteC;
				var lat, lon;
				var marker;
				/**
				* se inicializa la construccion del mapa.
				* se realizan diferentes instancias de las clases de la api de googlemaps
				* geocoder para la localizacion inversa.
				* maps para crear el mapa
				* LatLng para los puntos de latitud y longitud
				* autocomplete para la busqueda de lugares mediante el input
				* PlacesServices para la localizacion de lugares y recuperar dicha informacion.
				* marker par crear los marcadores en el mapa.
				*/
				function initialize() {
					var myLatlng = new google.maps.LatLng(28.6600836,-15.6965996,2);
					var myOptions = {
						zoom: 1,
						center: myLatlng,
						mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					map1 = new google.maps.Map(document.getElementsByClassName('map_canvas')[0], myOptions);
					map2 = new google.maps.Map(document.getElementsByClassName('map_canvas')[1], myOptions);

					autocompleteP = new google.maps.places.Autocomplete(document.getElementsByClassName('autocomplete')[0]);
					autocompleteC = new google.maps.places.Autocomplete(document.getElementsByClassName('autocomplete')[1]);
					google.maps.event.addListener(autocompleteP, 'place_changed', function() {
						buscarLugar(autocompleteP, map1, "pais");
					});
					google.maps.event.addListener(autocompleteC, 'place_changed', function() {
						buscarLugar(autocompleteC, map2, "ciudad");
					});
				}
				// busca un lugar mediante la clase autocomplete
				function buscarLugar(autocompletee, mp, lugarPC) {

					var place = autocompletee.getPlace();
					mp.panTo(place.geometry.location);
					if(lugarPC == "pais"){
						
						var cadena = place.geometry.location;
						$("#coordenadasPais").val(cadena);
					}else $("#coordenadasCiudad").val(place.geometry.location);
					mp.setZoom(13);
					markers[0] = new google.maps.Marker({
						position: place.geometry.location,
						map: mp
					});
					iw = new google.maps.InfoWindow({
						content: obtenerInfo(place)
					});
					iw.open(mp, markers[0]);
				}
				// funcion que añade informacion al cuadro de texto de los marcadores.
				function obtenerInfo(place) {
					var content = '<table style="border:0"><tr>'
					content += '<td style="border:0;"><b><a href="' + place.url + '" target="_blank">' + place.name + '</a></b>';
					content += '</td></tr></table>';
					return content;
				}
				window.onload = initialize();
			</script>
		</div>
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