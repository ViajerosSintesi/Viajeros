<?php
/**
*
* pais-comentarios.php
* Documento que muestra todos los comentarios que se hayan realizado en un pais.
*
* @version 1.0
*
*/
session_start();
include("../funciones.php");
if(isset($_GET['pais'])){
	$pais = $_GET['pais'];
}
?>
<html>
<head>
	<title>Comentarios</title>
	<style>
	.imgperfil{
	      width:40px;
	      border-radius:20px;
	}
	</style>
	<script src="js/valoracion.js"></script>
	<script src="js/cargaScript.js"></script>
	<script type="text/javascript">
	$(function(){
		cargarComents('<?php echo $pais;?>', '<?php echo $_SESSION['userId'];?>', 'Pais');
	});
	</script>
</head>
<body>
<div id="comentarios-pais"></div>
</body>
</html>