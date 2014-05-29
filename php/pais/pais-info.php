<?php
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
$("#edit-info-pais").click(function(){
	var pais= "<?php echo $_GET['pais']; ?>";
	editInfoPais(pais);
});
</script>
<div id="info">
	<?php if($session == 1){?>
	<div id="edit-info-pais"><img src="img/png/edit_32px.png"></div>
	<?php } echo nl2br($info['info']); ?>
</div>