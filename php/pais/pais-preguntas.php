<?php
session_start();
include("../funciones.php");
$pais = "";

if(isset($_GET['pais'])){
	$pais = $_GET['pais'];

	$cursor = cargarComentCiudad($pais);
	$session=1;
	// falta terminaar de implemaentar la funcion.
}
?>
<!doctype html>
<head>
	<title></title>
	<!--<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>-->
	<style>
	.imgperfil{
	      width:50px;
	      border-radius:20px;
	}
	.respuesta{
	      margin-left: 10%;
	}
	</style>
	<script src="js/cargaScript.js"></script>
	<script src="js/valoracion.js"></script>
	
	<script type="text/javascript">
            $(function(){
                  cargarPreguntas('<?php echo $pais;?>', '<?php echo $_SESSION['userId'];?>', 'Pais');
                  
            });
            
	      
	</script>
</head>
<body>

<div id="preguntas-pais">

</div>
</body>
</html>