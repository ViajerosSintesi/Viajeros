<?php
/**
*
* pais-preguntas.php
* En este document se muestra todas las preguntas que realizan los usuarios sobre algún país
* tambien se muetran las respuestas a dichas preguntas, además de realizar nuevas preguntas y
* de responder a cualquier pregunta.
* @version 1.0
*
*/
session_start();
include("../funciones.php");
$pais = "";
if(isset($_GET['pais'])){
	$pais = $_GET['pais'];
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
		cargarPreguntas('<?php echo $pais;?>', '<?php echo $_SESSION['userId'];?>', 'Pais');
	});
	</script>
</head>
<body>
<div id="preguntas-pais"></div>
</body>
</html>