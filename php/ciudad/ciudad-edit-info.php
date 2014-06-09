<?php
/**
* ciudad-edit-info.php
* En este documento se obtiene la informacion de la base de datos de una ciudad
* y se muestra en un textarea en el cual se podrá modificar dicho contenido y guardarlo.
*
* @version 1.0
*
*/
include("../funciones.php");
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