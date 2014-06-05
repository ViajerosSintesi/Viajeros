<?php
session_start();
include("../funciones.php");
$ciudad = "";
if(isset($_GET['ciudad'])){
	$ciudad = $_GET['ciudad'];
	$cursor = cargarComentCiudad($ciudad);
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
                  cargarPreguntas('<?php echo $ciudad;?>', '<?php echo $_SESSION['userId'];?>', 'Ciudad');
                  
            });
            
	      
	</script>
</head>
<body>

<div id="preguntas-pais">

</div>
</body>
</html>