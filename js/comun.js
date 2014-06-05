$(function(){
	//esconde el cuadro para subir imagenes
	$("#bg-cuadro").hide();
	$("#cuadro-foto").hide();
	$("#mapa-ubicacion").hide();
	//si se hace click al boton de subir imagenes, aparece el cuadro
	$("#subir-foto").click(function(){
		$("#bg-cuadro").show();
		$("#cuadro-foto").show();
	});
	//Mostrar el mapa de ubicacion actual
	$("#miUbicacion").click(function(){
		$("#bg-cuadro").show();
		//geolocalizacion();
		$("#mapa-ubicacion").append("<iframe src='geolocalizacion.php' id='geolocalizacion'></iframe>");
		$("#mapa-ubicacion").show();
	});
	//cerrar el cuadro de subri fotos
	$(".cerrar-cuadro").click(function(){
		$("#bg-cuadro").hide();
		$("#cuadro-foto").hide();
		$("#mapa-ubicacion").hide();
		$("#geolocalizacion").remove();
	});
	$("#buscar" ).autocomplete({
		source: buscador,
		select: function(){
			var res = document.getElementById("id").value;
			window.location=res;
		}
	});
	//Menu
	$("#hide-show-menu").click(function(){
		$("#barra-menu").toggle("slow",function(){
			var src = ($("#ico-menu").attr('src') === 'img/33.png')
			? 'img/32.png'
			: 'img/33.png';
			$("#ico-menu").attr('src', src);
		});
	});
});
