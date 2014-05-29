<?php
include("php/funciones.php");
session_start();
$ciudad = "";
$userId = null;
if(!isset($_SESSION['userId'])){
      header("location:index.php");
}else{
      if(isset($_GET['ciudad'])){
      	$ciudad = $_GET['ciudad'];
	      $userId = $_SESSION['userId'];
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
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="js/ajax.js"></script>
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
});
      function valoraciones(){
            $.getJSON("php/controles/controlValoracionCiudad.php",{"ciudad":"<?php echo $ciudad;?>", "verValor":"1"}, function(data){
                  $("#valoracionCiudad").html("Nota:"+data);
            });
            var queryForValoracionUsuario = {"ciudad":"<?php echo $ciudad;?>","userId":"<?php echo $userId;?>", "verValorUsuario":"1"};
            $.getJSON("php/controles/controlValoracionCiudad.php",queryForValoracionUsuario, function(data){
                  $("#valorCiudad"+data.valor).attr("checked", "true");
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
	<div id="header">
		<img src="img/logo.png">
	</div>
	<div id="contenedor">
	<span id="valoracionCiudad"></span>
	<form method="get" action="php/controles/controlValoracionCiudad.php" id="valorCiudad">
	            <input type="hidden" value="<?php echo $ciudad;?>" name="ciudad"/>
	            <input type="hidden" value="<?php echo $userId;?>" name="userId"/>
	            
		      0<input type="radio" name="valorCiudad" value="0" class="valorCiudad" id="valorCiudad0">
		      1<input type="radio" name="valorCiudad" value="1" class="valorCiudad" id="valorCiudad1">
		      2<input type="radio" name="valorCiudad" value="2" class="valorCiudad" id="valorCiudad2">
		      3<input type="radio" name="valorCiudad" value="3" class="valorCiudad" id="valorCiudad3">
		      4<input type="radio" name="valorCiudad" value="4" class="valorCiudad" id="valorCiudad4">
		      5<input type="radio" name="valorCiudad" value="5" class="valorCiudad" id="valorCiudad5">
		      6<input type="radio" name="valorCiudad" value="6" class="valorCiudad" id="valorCiudad6">
		      7<input type="radio" name="valorCiudad" value="7" class="valorCiudad" id="valorCiudad7">
		      8<input type="radio" name="valorCiudad" value="8" class="valorCiudad" id="valorCiudad8">
		      9<input type="radio" name="valorCiudad" value="9" class="valorCiudad" id="valorCiudad9">
		      10<input type="radio" name="valorCiudad" value="10" class="valorCiudad" id="valorCiudad10">
		</form>
		<div id="cabecera"><img src="img/home_img1.jpg"> 
		
		</div>
		<div id="menu-pais">
			<ul>
				<li><a href="#" id="informacion">Informaci&oacute;n</a></li>
				<li><a href="#" id="fotos">Fotos</a></li>
				<li><a href="#" id="comentarios">Comentarios</a></li>
				<li><a href="#" id="ubicacion">Ubicaci&oacute;n</a></li>
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