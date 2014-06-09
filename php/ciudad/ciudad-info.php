<?php
/**
*
* ciudad-info.php
* En este documento se muestra la información de cada ciudad.
* @version 1.0
*
*/
include("../funciones.php");
$ciudad = "";
if(isset($_GET['ciudad'])){
	$ciudad = $_GET['ciudad'];
	$info = obtenerInfoCiudad($ciudad);
	$session=1;
}
?>
<!--<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.10.4.custom.js"></script>-->
<script type="text/javascript">
$("#edit-info-lugar").click(function(){
	var ciudad= "<?php echo $_GET['ciudad']; ?>";
	editInfoCiudad(ciudad);
});
</script>
<div id="info">
	<?php if($session == 1){?>
	<div id="edit-info-lugar"><img src="img/78.png"></div>
	<?php } echo nl2br($info['info']); ?>
</div>