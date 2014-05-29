<?php
include("funciones.php");
if(isset($_GET['pais'])){
	$pais = $_GET['pais'];
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<div id="ciudades-pais">
	<div id='ciudades-pais'>
		<table id='tabla'>
			<?php
			$cursor = obtenerInfoPais($pais);
			$cursor = paisCiudades($cursor['_id']);
			$cont=0;
			$line=0;
			foreach ($cursor as $document) {
				$cont++;
				if($cont==1){
					$line++;
					echo "<tr class=line".$line.">"; 
				}
				echo "<td><a href='ciudad.php?ciudad=".$document['_id']."' id='enlace-ciudad'>".$document["ciudad"]."</a></td>";
				if($cont==3){ 
					echo "</tr>";
					$cont=0;
				}
			}
			?>
		</table>
	</div>
</div>