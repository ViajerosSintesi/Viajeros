<?php
/**
* pais-edit-info.php
* En este documento se obtiene la informacion de la base de datos de un pais
* y se muestra en un textarea en el cual se podrá modificar dicho contenido y guardarlo.
*
* @version 1.0
*
*/
include("../funciones.php");
$pais="";
if(isset($_GET['pais'])){
	$pais = $_GET['pais'];
	$cursor = obtenerInfoPais($pais);
}
?>
<div id="cuadro">
	<form action="#" method="post">
		<p><textarea name="info-pais" cols="80" rows="25"><?php echo $cursor['info'];?></textarea></p>
		<input type="submit" name="edit-info" value="Finalizar edici&oacute;n">
	</form>
</div>