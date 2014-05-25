<!DOCTYPE html>
<html>
<head>
	<title>Perfil Usuario</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="ajax.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#informacion").click(function(){
			infoPais();
			return false;
		});
		$("#fotos").click(function(){
			fotoPais();
			return false;
		});
		$("#ubicacion").click(function(){
			//ubicacionPais();
			document.getElementById("contenido-pais").innerHTML="<div id='mapa-pais'></div>";
			cargarmap1();
			return false;
		});
	});
	function cargarmap1() {
		//mapa-pais.style.height='300px';
		var mapOptions = {
		center: new google.maps.LatLng(40.2085,-3.713,6),
		zoom: 5,
		mapTypeId: google.maps.MapTypeId.ROADMAP};
		var map = new google.maps.Map(document.getElementById("mapa-pais"),mapOptions);
	}
	window.load=infoPais();
	</script>
</head>
<body>
<div id="wrap">
	<div id="header">
		<img src="img/logo.png">
	</div>
	<div id="contenedor">
		<div id="cabecera"><img src="img/home_img1.jpg"></div>
		<div id="menu-pais">
			<ul>
				<li><a href="#" id="informacion">Informaci&oacute;n</a></li>
				<li><a href="#" id="fotos">Fotos</a></li>
				<li><a href="#" id="comentarios">Comentarios</a></li>
				<li><a href="#" id="ubicacion">Ubicaci&oacute;n</a></li>
			</ul>
		</div>
		<div id="caja-pais">
			<div id="contenido-pais"></div>
		</div>
	</div>
	<div id="footer">
		<span><a href="#">Sobre nosotros</a></span>
		<span><a href="#">Condiciones</a></span>
		<span><a href="#">Privacidad</a></span>
		<span>&#64; 2014 Alumnos D.A.W.</span>
	</div>
</div>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
</body>
</html>