function cargarComents(e,t,n){var r={ciudad:e,userId:t,verComments:n};$.getJSON("php/controles/controlComment.php",r,function(r){var i="";for(var s=0;s<r.length;s++){i+='<div class="coments">';i+='<div class="coment-up">';i+='<p><form method="post" action="perfil.php" class="envioPerfil"><a href="#" class="linkPerfil"><input type="hidden" value="'+r[s].idUsu+'" name="user"/>';i+='<img class="imgperfil" src="'+r[s].imgPerfilUser+'"/>'+r[s].nombreDelUser+"</a></form></p>";i+="<p>"+r[s].comentario+"</p>";i+='<input type="hidden" id="idUsu'+s+'" value="'+t+'"/>';i+='<input type="hidden" id="idComent'+s+'" value="'+r[s]._id["$id"]+'"/>';i+="</div>";i+='<div class="coment-down">';i+='<span class="fecha">'+r[s].data+"</span>";i+='<button title="me gusta" class="meGusta" id="coment-'+s+'"><span id="countPos'+s+'">'+r[s].valorPos+"</span>";if(r[s].valorDelUser){if(r[s].valorDelUser.valor==2)i+='<img src="img/hand_pro_verde.png" >';else i+='<img src="img/hand_pro.png" >'}else i+='<img src="img/hand_pro.png" >';i+="</button>";i+='<button title="no me gusta" class="noMeGusta" id="coment-'+s+'"><span id="countNeg'+s+'">'+r[s].valorNeg+"</span>";if(r[s].valorDelUser){if(r[s].valorDelUser.valor==1)i+='<img src="img/hand_contra_roja.png" >';else i+='<img src="img/hand_contra.png" >'}else i+='<img src="img/hand_contra.png" >';i+="</button>";i+='<button title="reportar abuso" class="reportButton" id="report-'+s+'"><img src="img/hand_1.png" /></button>';i+="</div>";i+="</div>"}i+='<div id="subirComent">';i+='<form action="#" method="post">';i+='<textarea id="areatexto" cols="80" rows="5"></textarea>';i+='<input type="hidden" id="idUser" value="'+t+'"/>';i+='<input type="hidden" id="idSitio" value="'+e+'"/>';i+='<input type="hidden" id="tipo" value="'+n+'"/>';i+='<!-- <input type="submit" id="kiko" value="enviar"> -->';i+="</form>";i+="</div>";$("#comentarios-pais").html(i);$(".linkPerfil").click(function(){$(this).parent().submit()});$(".meGusta").click(function(){var r=$(this).attr("id");var i=r[r.length-1];var s=$("#idUsu"+i).val();var o=$("#idComent"+i).val();enviarValoracion("comment",2,s,o);cargarComents(e,t,n)});$(".noMeGusta").click(function(){var r=$(this).attr("id");var i=r[r.length-1];var s=$("#idUsu"+i).val();var o=$("#idComent"+i).val();enviarValoracion("comment",1,s,o);cargarComents(e,t,n)});$("#areatexto").keypress(function(e){if(e.keyCode==13&&!e.shiftKey){e.preventDefault();var t=$("#areatexto").val();var n=$("#idUser").val();var r=$("#idSitio").val();var i=$("#tipo").val();var s=(new Date).toString();var o={comentario:t,userId:n,ciudad:r,insertarComent:i,fecha:s};$.getJSON("php/controles/controlComment.php",o,function(e){if(e){alertify.success("comentado!! :)");cargarComents(r,n,i)}else alertify.error("que a pasado?!! :(")})}});$(".reportButton").click(function(){var e=$(this).attr("id");var t=e[e.length-1];var r=$("#idUsu"+t).val();var i=$("#idComent"+t).val();var s={reportarComent:n,userId:r,comentId:i};$.getJSON("php/controles/controlReporte.php",s,function(e){alertify.success("hagamos de este un sitio tranquilo!! :)");console.log(e)})})})}function cargarPreguntas(e,t,n){var r={ciudad:e,userId:t,verPreguntas:n};$.getJSON("php/controles/controlPregunta.php",r,function(r){var i="";for(var s=0;s<r.length;s++){i+='<div class="pregunta">';i+='<div class="pregunta-up">';i+='<p><form method="post" action="perfil.php" class="envioPerfil"><a href="#" class="linkPerfil"><input type="hidden" value="'+r[s].idUsu+'" name="user"/>';i+='<img class="imgperfil" src="'+r[s].imgPerfilUser+'"/>'+r[s].nombreDelUser+"</a></form></p>";i+="<p>"+r[s].pregunta+"</p>";i+='<input type="hidden" id="idUsu'+s+'" value="'+t+'"/>';i+='<input type="hidden" id="idPregunta'+s+'" value="'+r[s]._id["$id"]+'"/>';i+="</div>";i+='<div class="pregunta-down">';i+='<span class="fecha">'+r[s].data+"</span>";i+='<button title="me gusta" class="meGusta" id="pregunta-'+s+'"><span id="countPos'+s+'">'+r[s].valorPos+"</span>";if(r[s].valorDelUser){if(r[s].valorDelUser.valor==2)i+='<img src="img/hand_pro_verde.png" >';else i+='<img src="img/hand_pro.png" >'}else i+='<img src="img/hand_pro.png" >';i+="</button>";i+='<button title="no me gusta" class="noMeGusta" id="pregunta-'+s+'"><span id="countNeg'+s+'">'+r[s].valorNeg+"</span>";if(r[s].valorDelUser){if(r[s].valorDelUser.valor==1)i+='<img src="img/hand_contra_roja.png" >';else i+='<img src="img/hand_contra.png" >'}else i+='<img src="img/hand_contra.png" >';i+="</button>";i+='<button title="reportar abuso" class="reportButton" id="report-'+s+'"><img src="img/hand_1.png" /></button>';i+="</div>";i+='<button title="ver respuestas" class="ver-respuesta" id="report-'+s+'">respuestas</button>';i+='<div class="rspta"><div id="'+r[s]._id["$id"]+'"></div></div>';i+="</div>"}i+='<div id="subirPregunta">';i+='<form action="#" method="post">';i+='<textarea id="areatexto" cols="80" rows="5"></textarea>';i+='<input type="hidden" id="idUser" value="'+t+'"/>';i+='<input type="hidden" id="idSitio" value="'+e+'"/>';i+='<input type="hidden" id="tipo" value="'+n+'"/>';i+='<!-- <input type="submit" id="kiko" value="enviar"> -->';i+="</form>";i+="</div>";$("#preguntas-pais").html(i);$(".linkPerfil").click(function(){$(this).parent().submit()});$(".meGusta").click(function(){var r=$(this).attr("id");var i=r[r.length-1];var s=$("#idUsu"+i).val();var o=$("#idPregunta"+i).val();enviarValoracion("pregunta",2,s,o);cargarPreguntas(e,t,n)});$(".noMeGusta").click(function(){var r=$(this).attr("id");var i=r[r.length-1];var s=$("#idUsu"+i).val();var o=$("#idPregunta"+i).val();enviarValoracion("pregunta",1,s,o);cargarPreguntas(e,t,n)});$("#areatexto").keypress(function(e){if(e.keyCode==13&&!e.shiftKey){e.preventDefault();var t=$("#areatexto").val();var n=$("#idUser").val();var r=$("#idSitio").val();var i=$("#tipo").val();var s=(new Date).toString();var o={pregunta:t,userId:n,ciudad:r,insertarPregunta:i,fecha:s};$.getJSON("php/controles/controlPregunta.php",o,function(e){if(e){alertify.success("comentado!! :)");cargarPreguntas(r,n,i)}else alertify.error("que a pasado?!! :(")})}});$(".reportButton").click(function(){var e=$(this).attr("id");var t=e[e.length-1];var r=$("#idUsu"+t).val();var i=$("#idPregunta"+t).val();var s={reportarPregunta:n,userId:r,preguntaId:i};$.getJSON("php/controles/controlReporte.php",s,function(e){console.log(e);alertify.success("hagamos de este un sitio tranquilo!! :)")})});$(".ver-respuesta").click(function(){var e=$(this).attr("id");var t=e[e.length-1];var r=$("#idPregunta"+t).val();var i=$("#idUser").val();var s=$("#idSitio").val();cargarRespuestas(r,i,n)})})}function cargarRespuestas(e,t,n){var r={pregunta:e,userId:t,verRespuestas:n};$.getJSON("php/controles/controlRespuesta.php",r,function(r){var i="";for(var s=0;s<r.length;s++){i+='<div class="respuesta">';i+='<div class="respuesta-up">';i+='<p><form method="post" action="perfil.php" class="envioPerfil"><a href="#" class="linkPerfil"><input type="hidden" value="'+r[s].idUsu+'" name="user"/>';i+='<img class="imgperfil" src="'+r[s].imgPerfilUser+'"/>'+r[s].nombreDelUser+"</a></form></p>";i+="<p>"+r[s].respuesta+"</p>";i+='<input type="hidden" id="idUsu'+s+'" value="'+t+'"/>';i+='<input type="hidden" id="idRespuesta'+s+'" value="'+r[s]._id["$id"]+'"/>';i+="</div>";i+='<div class="respuesta-down">';i+='<span class="fecha">'+r[s].data+"</span>";i+='<button title="me gusta" class="meGusta" id="respuesta-'+s+'"><span id="countPos'+s+'">'+r[s].valorPos+"</span>";if(r[s].valorDelUser){if(r[s].valorDelUser.valor==2)i+='<img src="img/hand_pro_verde.png" >';else i+='<img src="img/hand_pro.png" >'}else i+='<img src="img/hand_pro.png" >';i+="</button>";i+='<button title="no me gusta" class="noMeGusta" id="respuesta-'+s+'"><span id="countNeg'+s+'">'+r[s].valorNeg+"</span>";if(r[s].valorDelUser){if(r[s].valorDelUser.valor==1)i+='<img src="img/hand_contra_roja.png" >';else i+='<img src="img/hand_contra.png" >'}else i+='<img src="img/hand_contra.png" >';i+="</button>";i+='<button title="reportar abuso" class="reportButton" id="report-'+s+'"><img src="img/hand_1.png" /></button>';i+="</div>";i+="</div>"}i+='<div id="subirRespuesta">';i+='<form action="#" method="post">';i+='<textarea id="areaTextoResp" cols="80" rows="5"></textarea>';i+='<input type="hidden" id="idUser" value="'+t+'"/>';i+='<input type="hidden" id="idSitio" value="'+e+'"/>';i+='<input type="hidden" id="tipo" value="'+n+'"/>';i+='<!-- <input type="submit" id="kiko" value="enviar"> -->';i+="</form>";i+="</div>";$("#"+e).html(i);$(".linkPerfil").click(function(){$(this).parent().submit()});$(".meGusta").click(function(){var r=$(this).attr("id");var i=r[r.length-1];var s=$("#idUsu"+i).val();var o=$("#idRespuesta"+i).val();enviarValoracion("respuesta",2,s,o);cargarRespuestas(e,t,n)});$(".noMeGusta").click(function(){var r=$(this).attr("id");var i=r[r.length-1];var s=$("#idUsu"+i).val();var o=$("#idRespuesta"+i).val();enviarValoracion("respuesta",1,s,o);cargarRespuestas(e,t,n)});$("#areaTextoResp").keypress(function(e){if(e.keyCode==13&&!e.shiftKey){e.preventDefault();var t=$("#areaTextoResp").val();var n=$("#idUser").val();var r=$("#idSitio").val();var i=$("#tipo").val();var s=(new Date).toString();var o={respuesta:t,userId:n,pregunta:r,insertarRespuesta:i,fecha:s};$.getJSON("php/controles/controlRespuesta.php",o,function(e){alertify.success("Perfecto!! :)");cargarRespuestas(r,n,i)})}});$(".reportButton").click(function(){var e=$(this).attr("id");var t=e[e.length-1];var r=$("#idUsu"+t).val();var i=$("#idRespuesta"+t).val();var s={reportarRespuesta:n,userId:r,respuestaId:i};$.getJSON("php/controles/controlReporte.php",s,function(e){alertify.success("hagamos de este un sitio tranquilo!! :)");console.log(e)})})})}$(function(){$("#cancelar-datos").click(function(){alertify.alert("clickado en cancelar");return false});$("#modificar-datos").click(function(){alertify.alert("clickado en modificar");return false});$("#kiko").click(function(){alertify.alert("envio comentario");return false})})