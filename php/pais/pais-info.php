<?php
/**
*
* pais-info.php
* En este documento se muestra la información de cada país.
* @version 1.0
*
*/
include("../funciones.php");
$pais="";
if(isset($_GET['pais'])){
	$pais = $_GET['pais'];
	$info = obtenerInfoPais($pais);
	$session=1;
}
?>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript">
// funcion para la edicion de la informacion.
$("#edit-info-lugar").click(function(){
	var pais= "<?php echo $_GET['pais']; ?>";
	editInfoPais(pais);
});
</script>
<div id="info">
	<?php if($session == 1){?>
	<div id="edit-info-lugar"><img src="img/78.png" alt="Editar informaci&oacute;n" title="Editar informaci&oacute;n"></div>
	<?php } echo nl2br($info['info']); ?>
</div>