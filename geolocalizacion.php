<?php
session_start();
$user = null;
if(!isset($_SESSION['userId'])){
	header("location:index.php");
}
include("php/funciones.php");
$alerta = "&nbsp;";
if($_POST){
	guardarUbicacion($_SESSION['userId'],$_POST['coor'], $_POST['info']);
	$alerta = "Ubicaci&oacute;n guardada con exito!";
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
var geocoder;
var map;
var infowindow = new google.maps.InfoWindow();
var marker;
var x=document.getElementById("alertas");
x.innerHTML = "<?php echo $alerta; ?>";
function getLocation(){
	if (navigator.geolocation){
		navigator.geolocation.getCurrentPosition(showPosition,showError);
	}else{
		x.innerHTML="Su navegador no soporta Geolocalizaci&oacute;n.";
	}
}

function showPosition(position){
	lat=parseFloat(position.coords.latitude);
	lon=parseFloat(position.coords.longitude);
	$("#coor").val(lat+","+lon);
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
				//alert(results[1].formatted_address);
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
function showError(error){
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
window.onload = getLocation();
</script>
</body>
</html>