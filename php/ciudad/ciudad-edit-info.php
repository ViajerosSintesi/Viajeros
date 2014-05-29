<?php include("../funciones.php");
$ciudad="";
if(isset($_GET['ciudad'])){
	$ciudad = $_GET['ciudad'];
	$cursor = obtenerInfoCiudad($ciudad);
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<div id="cuadro">
	<form action="#" method="post">
		<p><textarea name="info-ciudad" cols="80" rows="25"><?php echo $cursor['info'];?></textarea></p>
		<input type="submit" name="edit-info" value="Finalizar edici&oacute;n">
	</form>
</div>