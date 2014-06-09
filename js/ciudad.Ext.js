
$(function(){
		$("#informacion").click(function(){
			//infoCiudad();
			$("#contenido").load("ciudad-info.php?ciudad=<?php echo $ciudad;?>");
			return false;
		});
		$("#fotos").click(function(){
			//fotoCiudad();
			$("#contenido").load("ciudad-foto.php?ciudad=<?php echo $ciudad;?>");
			return false;
		});
		$("#comentarios").click(function(){
			//comentariosPais();
			$("#contenido").load("ciudad-comentarios.php?ciudad=<?php echo $ciudad;?>");
			return false;
		});
		$("#ubicacion").click(function(){
			//ubicacionPais();
			document.getElementById("contenido").innerHTML="<div id='mapa'></div>";
			cargarmap1();
			return false;
		});
		
	      $("input[@name='valorciudad']").change(function(){
                console.log(this);
            });
});
	function cargarmap1() {
		var mapOptions = {
		center: new google.maps.LatLng(<?php echo $coor; ?>),
		zoom: 12,
		mapTypeId: google.maps.MapTypeId.ROADMAP};
		var map = new google.maps.Map(document.getElementById("mapa"),mapOptions);
	}
	window.onload=function(){
		$("#contenido").load("ciudad-info.php?ciudad=<?php echo $ciudad;?>");
	};
	
	function enviarValoracion(){
	      console.log(this);
	}