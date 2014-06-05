<?php
include("php/funciones.php");
session_start();
$ciudad = "";
$userId = null;
if(!isset($_SESSION['userId'])){
      header("location:index.php");
}else{
      if(isset($_GET['ciudad'])){
            require_once("php/clases/CiudadClass.php");
      	$ciudad = $_GET['ciudad'];
	      $userId = $_SESSION['userId'];
	      $ciudadC = new Ciudad();
	    
      }
}

$coor = obtenerCoordenadasCiudad($ciudad);
if(@$_POST['edit-info']){
	modificarInfoCiudad($_POST['info-ciudad'], $ciudad);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Perfil Ciudad</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.10.4.min.css">
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/buscador.js"></script>
	<script src="js/comun.js"></script>
	<script type="text/javascript">
      
$(function(){
            
		$("#informacion").click(function(){
			//infoCiudad();
			$("#contenido").load("php/ciudad/ciudad-info.php?ciudad=<?php echo $ciudad;?>");
			return false;
		});
		
		$("#fotos").click(function(){
			//fotoCiudad();
			$("#contenido").load("php/ciudad/ciudad-foto.php?ciudad=<?php echo $ciudad;?>");
			return false;
		});
		$("#comentarios").click(function(){
			//comentariosPais();
			$("#contenido").load("php/ciudad/ciudad-comentarios.php?ciudad=<?php echo $ciudad;?>");
			return false;
		});
		$("#preguntas").click(function(){
			//comentariosPais();
			$("#contenido").load("php/ciudad/ciudad-preguntas.php?ciudad=<?php echo $ciudad;?>");
			return false;
		});
		$("#ubicacion").click(function(){
			//ubicacionPais();
			document.getElementById("contenido").innerHTML="<div id='mapa'></div>";
			cargarmap1();
			return false;
		});
		
		$(".valorCiudad").change(function(){
			$("#valorCiudad").submit();
		});
		valoraciones();
		var dataForName = {"nombreCiudad": '<?php echo $ciudad;?>'};
		$.getJSON("php/controles/controlCiudad.php", dataForName, function(data){
			$("#nombreCity").html(data);
		})
});
      function valoraciones(){
            $.getJSON("php/controles/controlValoracionCiudad.php",{"ciudad":"<?php echo $ciudad;?>", "verValor":"1"}, function(data){
                  if(data!=null)$("#valoracion-lugar").html(data);
            });
            var queryForValoracionUsuario = {"ciudad":"<?php echo $ciudad;?>","userId":"<?php echo $userId;?>", "verValorUsuario":"1"};
            $.getJSON("php/controles/controlValoracionCiudad.php",queryForValoracionUsuario, function(data){
                  if(data!=null)$("#valorCiudad"+data.valor).attr("checked", "true");
            });
      }
	function cargarmap1() {
		var mapOptions = {
		center: new google.maps.LatLng(<?php echo $coor; ?>),
		zoom: 12,
		mapTypeId: google.maps.MapTypeId.ROADMAP};
		var map = new google.maps.Map(document.getElementById("mapa"),mapOptions);
	}
	window.onload=function(){
		$("#contenido").load("php/ciudad/ciudad-info.php?ciudad=<?php echo $ciudad;?>");
	};
	
	function enviarValoracion(){
	      console.log(this);
	}
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
	<div id="contenedor">
		<div id="cabecera">
			<!-- <img src="img/home_img1.jpg"> -->
			<span id="valoracion-lugar"></span>
			<div id="subcabecera-lugar">
				<div id="titulo-lugar">
					<?php $nombreCiudad = obtenerInfoCiudad($ciudad);?>
					<h1><?php echo $nombreCiudad['ciudad']; ?></h1>
				</div>
				<div id="puntuacion">
					<form method="get" action="php/controles/controlValoracionPais.php" id="valorPais">
						<input type="hidden" value="<?php echo $ciudad;?>" name="ciudad"/>
						<input type="hidden" value="<?php echo $userId;?>" name="userId"/>
						<?php for($i=0;$i<10;$i++){ ?>
						<img src="img/226.png" alt="Valoraci&oacute;n estrella"><input type="radio" name="valorCiudad" value="<?php echo $i+1;?>" class="valorCiudad" id="valorCiudad<?php echo $i+1;?>" title="Puntuaci&oacute;n">
						<?php } ?>
					</form>
				</div>
			</div>
		</div> 
		<div id="menu-pais">
			<ul>
				<li><a href="#" id="informacion" title="Informaci&oacute;n">Informaci&oacute;n</a></li>
				<li><a href="#" id="fotos" title="Galeria de imagenes">Fotos</a></li>
				<li><a href="#" id="comentarios" title="Comentarios sobre la ciudad">Comentarios</a></li>
				<li><a href="#" id="ubicacion" title="Ubicaci&oacute;n en el mapa">Ubicaci&oacute;n</a></li>
			</ul>
		</div>
		<div id="caja-contenido">
			<div id="contenido"></div>
		</div>
		<div id="bg-cuadro">
			<div id="mapa-ubicacion">
				<div class="cerrar-cuadro"><img src="img/75.png" alt="Cerrar cuadro" title="Cerrar"></div>
			</div>
		</div>
	</div>
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