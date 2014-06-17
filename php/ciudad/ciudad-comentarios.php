<?php
/**
*
* ciudad-comentarios.php
* Documento que muestra todos los comentarios que se hayan realizado en una ciudad.
*
* @version 1.0
*
*/
session_start();
include("../funciones.php");
$ciudad = "";
if(isset($_GET['ciudad'])){
	$ciudad = $_GET['ciudad'];
	$session=1;
	// falta terminaar de implemaentar la funcion.
}
?>
<!doctype html>
<head>
	<title>Ciudad</title>
	<style>
	.imgperfil{
	      width:50px;
	      border-radius:20px;
	}
	</style>
	<!--<script src="js/cargaScript.Ext.js"></script>-->
	
	<script src="js/valoracion.js"></script>
	<script type="text/javascript">
	$(function(){
		cargarComents('<?php echo $ciudad;?>', '<?php echo $_SESSION['userId'];?>', 'Ciudad');
	});
	</script>
</head>
<body>
<div id="comentarios-pais"></div>
</body>
</html>