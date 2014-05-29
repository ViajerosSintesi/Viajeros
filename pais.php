<?php
include("funciones.php");

if(isset($_SESSION['userId'])){
      header("location:index.php");
}else{
      if(isset($_GET['pais'])){
      	$pais = $_GET['pais'];
      	$coor = obtenerCoordenadasPais($pais);
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
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="ajax.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#informacion").click(function(){
			//infoPais("España");
			$("#contenido").load("pais-info.php?pais=<?php echo $pais; ?>");
			return false;
		});
		$("#fotos").click(function(){
			//fotoPais();
			$("#contenido").load("pais-foto.php?pais=<?php echo $pais; ?>");
			return false;
		});
		$("#comentarios").click(function(){
			//comentariosPais();
			$("#contenido").load("pais-comentarios.php?pais=<?php echo $pais; ?>");
			return false;
		});
		$("#ubicacion").click(function(){
			//ubicacionPais();
			document.getElementById("contenido").innerHTML="<div id='mapa'></div>";
			cargarmap1();
			return false;
		});
		$("#ciudades").click(function(){
			ciudadesPais("<?php echo $pais; ?>");
			return false;
		});
	});
	function cargarmap1() {
		//alert("desde php <?php echo $coor; ?>");
		var mapOptions = {
		center: new google.maps.LatLng(<?php echo $coor; ?>),
		zoom: 5,
		mapTypeId: google.maps.MapTypeId.ROADMAP};
		var map = new google.maps.Map(document.getElementById("mapa"),mapOptions);
	}
	//window.load=infoPais();
	window.onload=function(){
		$("#contenido").load("pais-info.php?pais=<?php echo $pais; ?>");
	};
	</script>
</head>
<body>
<form action="php/controlLogin.php" method="post">
	<input type="submit" name="destroySession" value="cerrar session" /> 
</form>
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
				<li><a href="#" id="ciudades">Ciudades</a></li>
			</ul>
		</div>
		<div id="caja-contenido">
			<div id="contenido"></div>
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