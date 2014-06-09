<?php
/**
*
* ciudad-preguntas.php
* En este document se muestra todas las preguntas que realizan los usuarios sobre algúna ciudad
* tambien se muetran las respuestas a dichas preguntas, además de realizar nuevas preguntas y
* de responder a cualquier pregunta.
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
	<title>Preguntas</title>
	<link rel="stylesheet" type="text/css" href="css/preguntas-style.css">
	<script src="js/cargaScript.js"></script>
	<script src="js/valoracion.js"></script>
	<script type="text/javascript">
	$(function(){
		cargarPreguntas('<?php echo $ciudad;?>', '<?php echo $_SESSION['userId'];?>', 'Ciudad');
	});
	</script>
</head>
<body>
<div id="preguntas-pais"></div>
</body>
</html>