<?php
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
	<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.min.js"></script>
	<script src="js/buscador.js"></script>
	<script src="js/ajax.js"></script>
	<script src="js/comun.js"></script>
	<script type="text/javascript">
	$(function(){
		$("#informacion").click(function(){
			//infoPais("España");
			$("#contenido").load("php/pais/pais-info.php?pais=<?php echo $pais; ?>");
			return false;
		});
		$("#fotos").click(function(){
			//fotoPais();
			$("#contenido").load("php/pais/pais-foto.php?pais=<?php echo $pais; ?>");
			return false;
		});
		$("#comentarios").click(function(){
			//comentariosPais();
			$("#contenido").load("php/pais/pais-comentarios.php?pais=<?php echo $pais; ?>");
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
      $(".valorPais").change(function(){
                $("#valorPais").submit();
            });
            valoraciones();
});
      function valoraciones(){
            $.getJSON("php/controles/controlValoracionPais.php",{"pais":"<?php echo $pais;?>", "verValor":"1"}, function(data){
                  if(data!=null)$("#valoracionPais").html("Nota:"+data);
            });
            var queryForValoracionUsuario = {"pais":"<?php echo $pais;?>","userId":"<?php echo $userId;?>", "verValorUsuario":"1"};
            $.getJSON("php/controles/controlValoracionPais.php",queryForValoracionUsuario, function(data){
                  if(data!=null)$("#valorPais"+data.valor).attr("checked", "true");
            });
      }
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
		$("#contenido").load("php/pais/pais-info.php?pais=<?php echo $pais; ?>");
	};
	</script>
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
	      <span id="valoracionPais"></span>
	      <form method="get" action="php/controles/controlValoracionPais.php" id="valorPais">
	            <input type="hidden" value="<?php echo $pais;?>" name="pais"/>
	            <input type="hidden" value="<?php echo $userId;?>" name="userId"/>
	            
		      1<input type="radio" name="valorPais" value="1" class="valorPais" id="valorPais1">
		      2<input type="radio" name="valorPais" value="2" class="valorPais" id="valorPais2">
		      3<input type="radio" name="valorPais" value="3" class="valorPais" id="valorPais3">
		      4<input type="radio" name="valorPais" value="4" class="valorPais" id="valorPais4">
		      5<input type="radio" name="valorPais" value="5" class="valorPais" id="valorPais5">
		      6<input type="radio" name="valorPais" value="6" class="valorPais" id="valorPais6">
		      7<input type="radio" name="valorPais" value="7" class="valorPais" id="valorPais7">
		      8<input type="radio" name="valorPais" value="8" class="valorPais" id="valorPais8">
		      9<input type="radio" name="valorPais" value="9" class="valorPais" id="valorPais9">
		      10<input type="radio" name="valorPais" value="10" class="valorPais" id="valorPais10">
		</form>
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