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
function imagenDialog(userId, divId){
      
        var dataImgValoracion = {
            "verValor": 1,
            "userId": userId,
            "img": divId
        };
        $.getJSON("php/controles/controlValoracionImg.php", dataImgValoracion, function (data) {
        
            //console.log(data);
            var htmlInsert = "";
            if (data) {
                htmlInsert = '<button title="me gusta" class="meGusta"><span id="countPos">' + data.valores.valorPos + '</span>';
                if (data.valorUsu) {
                    if (data.valorUsu.valor == 2) htmlInsert += '<img src="img/hand_pro_verde.png" >';
                    else htmlInsert += '<img src="img/hand_pro.png" >';
                } else htmlInsert += '<img src="img/hand_pro.png" >';
                htmlInsert += '</button>';
                htmlInsert += '<button title="no me gusta" class="noMeGusta"><span id="countNeg">' + data.valores.valorNeg + '</span>';
                if (data.valorUsu) {
                    if (data.valorUsu.valor == 1) htmlInsert += '<img src="img/hand_contra_roja.png" >';
                    else htmlInsert += '<img src="img/hand_contra.png" >';
                } else htmlInsert += '<img src="img/hand_contra.png" >';
                htmlInsert += '</button>';
            }
            
            $("#" + divId).html($("#" + divId).html() + htmlInsert);
            
            $(".meGusta").click(function () {
                enviarValoracion("img", 2, userId, divId);
            });

            $(".noMeGusta").click(function () {
                enviarValoracion("img", 1, userId, divId);

            });
            $("#" + divId).html($("#" + divId).html() + '<input type="button" class="borrarImg" value="borrar" name="' + divId + '"/><input type="button" class="reportarImg" value="reportar" name="' + divId + '"/>');
            
            $('.borrarImg').click(function () {
                borrarImagen(this);
                $("#" + divId).dialog("close", "duration", 1000);
            });
            $('.reportarImg').click(function () {
                reportarImagen(divId, userId);
                  $("#"+divId).dialog("close ", "duration ", 1000);
            });
            $("#"+divId).append($(this).clone());

            $("#"+divId+" > img ").addClass("imagen - dialogo ");
            $("#"+divId).dialog({
            
                  modal: true,
                  title: "Caja con opciones ",
                  width: 720,
                  minWidth: 720,
                  maxWidth: 1080,
                  maxHeight: 1080,
                  show: "fold ",
                  hide: "scale "
            });
        });
    
}
