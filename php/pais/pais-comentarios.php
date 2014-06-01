<?php
session_start();
include("../funciones.php");
if(isset($_GET['pais'])){
	$pais = $_GET['pais'];
}
?>
<html>
<head>
	<title></title>
	<!--<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>-->
	
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


<div id="comentarios-pais">
	
</div>
</body>
</html>