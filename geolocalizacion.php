<?php
/**
* geolocalizacion.php
* Este archivo permite obtener las coordenadas de ubicacion del usuario 
* para luego mostrar la ubicacion en un mapa de google.
* Tambien guarda la ubicacion del usuario en la base de datos.
* 
* @version 1.0
*
*/
session_start();
$user = null;
if(!isset($_SESSION['userId'])){
	header("location:index.php");
}
include("php/funciones.php");
$alerta = "&nbsp;";
$deshabilitar = false;
if($_POST){
	guardarUbicacion($_SESSION['userId'],$_POST['coor'], $_POST['info']);
	$alerta = "Ubicaci&oacute;n guardada con exito!";
	$deshabilitar = true;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
	<style type="text/css">
		body{text-align: center; margin: 0; padding: 0;}
		p{margin: 5px;}
		#map-div{height: 350px; width: 600px; margin: 0 auto;}
		input[type=submit]{padding: 5px 4px; background: url(img/blue.gif); color: #fff; font-size: 12px;
		border-radius:4px; -moz-border-radius:4px; -webkit-border-radius:4px;}
	</style>
</head>
<body>
<p id="alertas"></p>
<div id="map-div"></div>
<form method="post">
	<input type="hidden" name="coor" id="coor">
	<input type="hidden" name="info" id="info">
	<input type="submit" name="guardarUbicacion" id="guardarUbicacion" value="Guardar Ubicaci&oacute;n">
</form>
<script>
/**
* funciones javascript y api de google.maps
*/
var geocoder;
var map;
var infowindow = new google.maps.InfoWindow();// para añadir información.
var marker;
var x=document.getElementById("alertas");
x.innerHTML = "<?php echo $alerta; ?>";
var deshabilitar = "<?php echo $deshabilitar; ?>";
// deshabilita el boton de guardar la ubiación, así solo se usa una sola vez.
if(deshabilitar){
	$("#guardarUbicacion").prop("disabled", true);
	$("#guardarUbicacion").css("background", "url(img/pattern.png)");
	$("#guardarUbicacion").css("color", "#000");
}
// funcion para obtener las coordenadas.
function obtenerUbicacion(){
	if (navigator.geolocation){
		navigator.geolocation.getCurrentPosition(mostrarUbicacion,mostrarError);
	}else{
		x.innerHTML="Su navegador no soporta Geolocalizaci&oacute;n.";
	}
}
// funcion en la que muestra la ubiacion en el mapa del usuario, mediante un marker(icono en el mapa).
function mostrarUbicacion(posicion){
	//coordenadas
	lat=parseFloat(posicion.coords.latitude);
	lon=parseFloat(posicion.coords.longitude);
	//guarda las coordenadas en un input oculto
	$("#coor").val(lat+","+lon);
	//instancia un mapa de tipo Geocoder, con este tipo podemos optener el nombre del lugar que citan las coordenadas.
	geocoder = new google.maps.Geocoder();
	var latlng = new google.maps.LatLng(lat,lon);
	var mapOptions = {
		zoom: 8,
		center: latlng,
		mapTypeId: 'roadmap'
	}
	map = new google.maps.Map(document.getElementById('map-div'), mapOptions);
	geocoder.geocode({'latLng': latlng}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			if (results[1]) {
				map.setZoom(15);
				marker = new google.maps.Marker({
					position: latlng,
					map: map
				});
				infowindow.setContent(results[1].formatted_address);
				$("#info").val(results[1].formatted_address);
				infowindow.open(map, marker);
			} else {
				alert('No se encontraron resultados');
			}
		} else {
			alert('Geolocalizaci&oacute;n fallo debido a: ' + status);
		}
	});
}
// funcion que muestra posibles errores de geolocalización.
function mostrarError(error){
	switch(error.code){
		case error.PERMISSION_DENIED:
			x.innerHTML="Petici&oacute;n de Geolocalizaci&oacute;n denegada por el usuario."
			break;
		case error.POSITION_UNAVAILABLE:
			x.innerHTML="Informaci&oacute;n de la ubicaci&oacute;n no disponible."
			break;
		case error.TIMEOUT:
			x.innerHTML="El tiempo de espera de petici&oacute;n para la localizaci&oacute;n a expirado."
			break;
		case error.UNKNOWN_ERROR:
			x.innerHTML="Ocurrio un error desconocido."
			break;
	}
}
window.onload = obtenerUbicacion();
</script>
</body>
</html>