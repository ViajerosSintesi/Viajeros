<?php
/**
* 
* pais.php
* Este documento contiene la ficha de cada pais, este documento recopila toda 
* la informacion del pais seleccionado.
* Se utilizan las tecnologias de ajax, javascript y php.
*
*/
include("php/funciones.php");
session_start();
if(!isset($_SESSION['userId'])){
      header("location:index.php");
}else{
      if(isset($_GET['pais'])){
      	$pais = $_GET['pais'];
      	$coor = obtenerCoordenadasPais($pais);
      	$userId = $_SESSION['userId'];
      }
}
if(@$_POST['edit-info']){
	modificarInfoPais($pais, $_POST['info-pais']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Perfil Pa&iacute;s</title>
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
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
	<script type="text/javascript">
	/**
	* Codigo javascript utilizando la libreria Jquery
	*/
	$(function(){
		// Carga la informacion del pais.
		$("#informacion").click(function(){
			//infoPais("España");
			$("#contenido").load("php/pais/pais-info.php?pais=<?php echo $pais; ?>");
			return false;
		});
		// Carga las fotos de dicho pais.
		$("#fotos").click(function(){
			//fotoPais();
			$("#contenido").load("php/pais/pais-foto.php?pais=<?php echo $pais; ?>");
			return false;
		});
		// Carga los comentarios
		$("#comentarios").click(function(){
			//comentariosPais();
			$("#contenido").load("php/pais/pais-comentarios.php?pais=<?php echo $pais; ?>");
			return false;
		});
		// Carga la ubicacion en el mapa.
		$("#ubicacion").click(function(){
			//ubicacionPais();
			document.getElementById("contenido").innerHTML="<div id='mapa'></div>";
			cargarmap1();
			return false;
		});
		// Carga el listado de ciudades de un pais.
		$("#ciudades").click(function(){
			ciudadesPais("<?php echo $pais; ?>");
			return false;
		});
		// Valoracion de un pais.
		$(".valorPais").change(function(){
			$("#valorPais").submit();
		});
		// Carga las preguntas sobre un pais.
		$("#preguntas").click(function(){
			//comentariosPais();
			$("#contenido").load("php/pais/pais-preguntas.php?pais=<?php echo $pais;?>");
			return false;
		});
		valoraciones();
	});
	// Funcion para realizar la valoracion 
	function valoraciones(){
		$.getJSON("php/controles/controlValoracionPais.php",{"pais":"<?php echo $pais;?>", "verValor":"1"}, function(data){
			if(data!=null)$("#valoracion-lugar").html(data);
		});
		var queryForValoracionUsuario = {"pais":"<?php echo $pais;?>","userId":"<?php echo $userId;?>", "verValorUsuario":"1"};
		$.getJSON("php/controles/controlValoracionPais.php",queryForValoracionUsuario, function(data){
			if(data!=null)$("#valorPais"+data.valor).attr("checked", "true");
		});
	}
	// Funcion para cargar mapa
	function cargarmap1() {
		var mapOptions = {
		center: new google.maps.LatLng(<?php echo $coor; ?>),
		zoom: 5,
		mapTypeId: google.maps.MapTypeId.ROADMAP};
		var map = new google.maps.Map(document.getElementById("mapa"),mapOptions);
	}
	window.onload=function(){
		$("#contenido").load("php/pais/pais-info.php?pais=<?php echo $pais; ?>");
	};
	</script>
</head>
<body>
<div id="wrap">
	<div id="menu">
		<button id="hide-show-menu" title="Ocultar/mostrar barra de men&uacute;">Barra men&uacute; <img src="img/33.png" id="ico-menu" alt="Ocultar men&uacute;"></button>
		<div id="barra-menu">
			<input type="text" id="buscar" title="Buscar ciudad, pa&iacute;s">
			<input type="hidden" value="" id="id" />
			<ul>
				<li><a href="#" id="miUbicacion" title="Obterner ubicaci&oacute;n" alt="Obterner ubicaci&oacute;n"><img src="img/161.png" alt="Obterner ubicaci&oacute;n"></a></li>
				<li><a href="perfil.php" title="Ir a perfil" alt="Ir a perfil">Perfil</a></li>
				<li><a href="list-pais.php" title="Lista de paises" alt="Lista de paises">Paises</a></li>
				<li><a href="mapa.php" title="Muestra el mapa" alt="Muestra el mapa">Mapa</a></li>
				<li><form action="php/controles/controlLogin.php" method="post">
						<input type="submit" name="destroySession" id="destroySession" value="Cerrar session" title="Cambiar foto de perfil" /> 
					</form></li>
			</ul>
		</div>
	</div>
	<div id="header">
		<img src="img/logo.png" alt="Logo corporativo">
	</div>
	<!-- Cuerpo principal -->
	<div id="contenedor">
		<!-- cabecera -->
		<div id="cabecera">
			<!-- <img src="img/home_img1.jpg"> -->
			<span id="valoracion-lugar"></span>
			<div id="subcabecera-lugar">
				<div id="titulo-lugar">
					<?php $nombrePais = obtenerInfoPais($pais);?>
					<h1><?php echo $nombrePais['pais']; ?></h1></div>
				<div id="puntuacion">
					<form method="get" action="php/controles/controlValoracionPais.php" id="valorPais">
						<input type="hidden" value="<?php echo $pais;?>" name="pais"/>
						<input type="hidden" value="<?php echo $userId;?>" name="userId"/>
						<?php for($i=0;$i<10;$i++){ ?>
						<img src="img/226.png" alt="Valoraci&oacute;n estrella"><input type="radio" name="valorPais" value="<?php echo $i+1;?>" class="valorPais" id="valorPais<?php echo $i+1;?>" title="Puntuaci&oacute;n">
						<?php } ?>
					</form>
				</div>
			</div>
		</div>
		<!-- menu interno del pais -->
		<div id="menu-pais">
			<ul>
				<li><a href="#" id="informacion" title="Informaci&oacute;n">Informaci&oacute;n</a></li>
				<li><a href="#" id="fotos" title="Galeria de imagenes">Fotos</a></li>
				<li><a href="#" id="comentarios" title="Comentarios sobre el pa&iacute;s">Comentarios</a></li>
				<li><a href="#" id="preguntas" title="Preguntas de los usuarios">Preguntas</a></li>
				<li><a href="#" id="ubicacion" title="Ubicaci&oacute;n en el mapa">Ubicaci&oacute;n</a></li>
				<li><a href="#" id="ciudades" title="Lista todas las ciudades del pa&iacute;s">Ciudades</a></li>
			</ul>
		</div>
		<!-- cuadro donde se cargara toda la informacion relativa al pais -->
		<div id="caja-contenido">
			<div id="contenido"></div>
		</div>
		<!-- cuadro que muestra la ubicacion -->
		<div id="bg-cuadro">
			<div id="mapa-ubicacion">
				<div class="cerrar-cuadro"><img src="img/75.png" alt="Cerrar cuadro" title="Cerrar"></div>
			</div>
		</div>
	</div>
	<!-- footer -->
	<div id="footer">
		<span><a href="#" title="Informaci&oacute;n sobre nosotros">Sobre nosotros</a></span>
		<span><a href="#" title="Condiciones de uso de la web">Condiciones</a></span>
		<span><a href="#" title="Terminos de privacidad">Privacidad</a></span>
		<span>&#64; 2014 Alumnos D.A.W.</span>
	</div>
</div>
<script src="http://maps.google.com/maps/api/js?sensor=false"></script>
</body>
</html>