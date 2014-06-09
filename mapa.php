<?php
/**
*
* mapa.php
* Este documento .php carga un mapa con la ubicación del usuario logueado.
* y contiene una lista que permite mostrar por categorias los lugares que
* al usuario le gustaria saber.
*
*/
include("php/funciones.php");
?>
<!DOCTYPE html>
<html>
<head>
	<title>Mapa</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/mapa-style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.4.min.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/buscador.js"></script>
	<script src="js/comun.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&libraries=places"></script>
</head>
<body>
<div id="wrap">
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
	<div id="header">
		<img src="img/logo.png">
	</div>
	<div id="contenedor">
		<div id="contenedor-mapa">
			<div id="titulo">
				<h1>Mapa</h1>
			</div>
			<div id="mapa">
				<p id="alertas"></p>
				<div id="busc-input">
					<input id="autocomplete" type="text">
				</div>
				<div id="map_canvas"></div>
				<div id="lista">
					<div id="opciones">
						<form name="opciones">
							<select id="bsqda" name="type">
								<option value="establishment">Todo</option>
								<option value="restaurant">Restaurantes</option>
								<option value="lodging">Alojamiento</option>
								<option value="museum">Museos</option>
								<option value="amusement_park">Parque de atracciones</option>
								<option value="art_gallery">Galeria de arte</option>
								<option value=""></option>
							</select>
						</form>
					</div>
					<table id="resultados"></table>
				</div>
			</div>
		</div>
		<script type="text/javascript">
		/**
		* Funciones javascript para la implementación del mapa.
		*/
		$(function(){
			$("#bsqda").change(function(){
				buscar();
			});
		});
		// declaracion de variables.
		var map, places, iw;
		var markers = [];
		var autocomplete;
		var lat, lon;
		var geocoder;
		var marker;
		//instacia de la clase InfoWindow del mapa
		var infowindow = new google.maps.InfoWindow();
		var x=document.getElementById("alertas");
		// funcion para iniciar la geolocalizacion.
		function getLocation(){
			if (navigator.geolocation){
				navigator.geolocation.getCurrentPosition(coordenadas);
			}else{
				x.innerHTML="Su navegador no soporta Geolocalizaci&oacute;n.";
			}
		}
		// se obtiene las coordenadas
		function coordenadas(position){
			lat=parseFloat(position.coords.latitude);
			lon=parseFloat(position.coords.longitude);
			initialize();
		}
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
			geocoder = new google.maps.Geocoder();
			var myLatlng = new google.maps.LatLng(lat, lon);
			var myOptions = {
				zoom: 10,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);

			geocoder.geocode({'latLng': myLatlng}, function(resultados, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					if (resultados[1]) {
						map.setZoom(13);
						marker = new google.maps.Marker({
							position: myLatlng,
							map: map
						});
						infowindow.setContent("Esta es t&uacute; posici&oacute;n");
						//alert(resultados[1].formatted_address);
						$("#info").val(resultados[1].formatted_address);
						infowindow.open(map, marker);
					} else {
						alert('No se encontraron resultados');
					}
				} else {
					alert('Geolocalizaci&oacute;n fallo debido a: ' + status);
				}
			});

			places = new google.maps.places.PlacesService(map);
			google.maps.event.addListener(map, 'tilesloaded', tilesLoaded); //cuando se terminan de cargar las fichas.
			autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'));
			google.maps.event.addListener(autocomplete, 'place_changed', function() {
				buscarLugar();
			});
		}
		// funcion que llama a otras funciones, dependiendo de los eventos realizados(zoom o moverse por el mata)
		function tilesLoaded() {
			google.maps.event.clearListeners(map, 'tilesloaded');
			google.maps.event.addListener(map, 'zoom_changed', buscar);
			google.maps.event.addListener(map, 'dragend', buscar);
			buscar();
		}
		// busca un lugar mediante la clase autocomplete
		function buscarLugar() {
			limpiarResultados();
			limpiarMarcadores();
			var place = autocomplete.getPlace();
			map.panTo(place.geometry.location);
			markers[0] = new google.maps.Marker({
				position: place.geometry.location,
				map: map
			});
			iw = new google.maps.InfoWindow({
				content: obtenerInfo(place)
			});
			iw.open(map, markers[0]);
		}
		// funcion que busca los lugares de interes cercanos.
		function buscar() {
			var type = document.opciones.type.value
			/*alert(type);*/
			autocomplete.setBounds(map.getBounds());
			var search = {
				bounds: map.getBounds()
			};

			if (type != 'establishment') {
				search.types = [type];
			}

			places.search(search, function(resultados, status) {
				if (status == google.maps.places.PlacesServiceStatus.OK) {
					limpiarResultados();
					limpiarMarcadores();
					for (var i = 0; i < resultados.length; i++) {
						markers[i] = new google.maps.Marker({
							position: resultados[i].geometry.location,
							animation: google.maps.Animation.DROP
						});
						google.maps.event.addListener(markers[i], 'click', obtenerDetalles(resultados[i], i));
						setTimeout(dropMarker(i), i * 100);
						agregrarResultado(resultados[i], i);
					}
				}
			});
		}
		// borra los marcadores que estan en el mapa
		function limpiarMarcadores() {
			for (var i = 0; i < markers.length; i++) {
				if (markers[i]) {
					markers[i].setMap(null);
					markers[i] == null;
				}
			}
		}
		// va haciendo aparecer los marcadores uno a uno
		function dropMarker(i) {
			return function() {
				markers[i].setMap(map);
			}
		}
		// añade celdas con informacion en la tabla resultados
		function agregrarResultado(result, i) {
			var resultados = document.getElementById('resultados');
			var tr = document.createElement('tr');
			tr.style.backgroundColor = (i% 2 == 0 ? '#F0F0F0' : '#FFFFFF');
			tr.onclick = function() {
				google.maps.event.trigger(markers[i], 'click');
			};

			var iconTd = document.createElement('td');
			var nameTd = document.createElement('td');
			var icon = document.createElement('img');
			icon.src = result.icon;//.replace('http:', '');
			icon.setAttribute('class', 'placeIcon');
			var name = document.createTextNode(result.name);
			iconTd.appendChild(icon);
			nameTd.appendChild(name);
			tr.appendChild(iconTd);
			tr.appendChild(nameTd);
			resultados.appendChild(tr);
		}
		// borra el contenido que contiene la tabla con el id resultados
		function limpiarResultados() {
			var resultados = document.getElementById('resultados');
			while (resultados.childNodes[0]) {
				resultados.removeChild(resultados.childNodes[0]);
			}
		}
		// Obtiene los detalles de un lugar especifico
		function obtenerDetalles(result, i) {
			return function() {
				places.getDetails({
					reference: result.reference
				}, mostrarInfo(i));
			}
		}
		// muestra la informacion de los marcadores
		function mostrarInfo(i) {
			return function(place, status) {
				if (iw) {
					iw.close();
					iw = null;
				}
				if (status == google.maps.places.PlacesServiceStatus.OK) {
					iw = new google.maps.InfoWindow({
						content: obtenerInfo(place)
					});
					iw.open(map, markers[i]);
				}
			}
		}
		// funcion que añade informacion al cuadro de texto de los marcadores.
		function obtenerInfo(place) {
			var content = '<table style="border:0"><tr><td style="border:0;">';
			content += '<img class="placeIcon" src="' + place.icon + '"></td>';
			content += '<td style="border:0;"><b><a href="' + place.url + '" target="_blank">' + place.name + '</a></b>';
			content += '</td></tr></table>';
			return content;
		}
		window.onload = getLocation();
		</script>
		<div id="bg-cuadro">
			<div id="mapa-ubicacion">
				<div class="cerrar-cuadro"><img src="img/75.png" alt="Cerrar cuadro" title="Cerrar"></div>
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