function validar_email(e){var t=/[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;if(t.test(e))return true;else return false}function validar_password(e){var t=0;var n=/[_0-9-]/g;var r=/[@0-9%]/g;var i=/[#0-9~]/g;var s=/[&0-9=]/g;var o=/[€0-9$]/g;var u=/[¿0-9?]/g;if(n.test(e)==true||r.test(e)==true||i.test(e)==true||s.test(e)==true||o.test(e)==true||u.test(e)==true){t=1}else{t=0}return t}function contrasenya_registro(){var e=0;var t=document.getElementById("contra").value;if($("#contra").val()==""){document.getElementById("no_registro").innerHTML="El password no puede estar vacio";$("#contra").css("border","3px solid red")}if(t.length<=4||validar_password($("#contra").val())==true){document.getElementById("no_registro").innerHTML="El password debe tener 5 o mas digitos y solo puede tener letras";$("#contra").css("border","3px solid red")}else{document.getElementById("no_registro").innerHTML="";$("#contra").css("border","1px solid blue");e=1}return e}function contrasenya_inicio(){var e=0;var t=document.getElementById("password").value;if($("#password").val()==""){document.getElementById("no_logeo").innerHTML="El password no puede estar vacio";$("#password").css("border","3px solid red")}if(t.length<=4||validar_password($("#password").val())==true){document.getElementById("no_logeo").innerHTML="El password debe tener 5 o mas digitos y solo puede tener letras";$("#password").css("border","3px solid red")}else{document.getElementById("no_logeo").innerHTML="";$("#password").css("border","1px solid blue");e=1}return e}function nombre_inicio(){var e=0;var t=document.getElementById("usuario").value;if(t.length<=3){document.getElementById("no_logeo").innerHTML="El nombre debe tener un minimo de 3 digitos";$("#usuario").css("border","3px solid red")}else{document.getElementById("no_logeo").innerHTML="";$("#usuario").css("border","1px solid blue");e=1}return e}function nombre_registro(){var e=0;var t=document.getElementById("nombre").value;if(t.length<=3){document.getElementById("no_registro").innerHTML="El nombre debe tener un minimo de 3 digitos";$("#nombre").css("border","3px solid red")}else{document.getElementById("no_registro").innerHTML="";$("#nombre").css("border","1px solid blue");e=1}return e}function apellido_registro(){var e=0;if($("#apellidos").val()==""){document.getElementById("no_registro").innerHTML="El apellido no puede estar vacio";$("#apellidos").css("border","3px solid red")}else{document.getElementById("no_registro").innerHTML="";$("#apellidos").css("border","1px solid blue");e=1}return e}function email_registro(){var e=0;if($("#email").val()==""){document.getElementById("no_registro").innerHTML="Ingrese un email";$("#email").css("border","3px solid red")}else if(validar_email($("#email").val())){document.getElementById("no_registro").innerHTML="";$("#email").css("border","1px solid blue");e=1}else{document.getElementById("no_registro").innerHTML="Email incorrecto";$("#email").css("border","3px solid red")}return e}function dia_registro(){var e=0;if($("#dia").val()==0){$("#dia").css("border","3px solid red")}else{$("#dia").css("border","1px solid blue");e=1}return e}function mes_registro(){var e=0;if($("#mes").val()==0){$("#mes").css("border","3px solid red")}else{$("#mes").css("border","1px solid blue");e=1}return e}function any_registro(){var e=0;if($("#any").val()==0){$("#any").css("border","3px solid red")}else{$("#any").css("border","1px solid blue");e=1}return e}function registroBoton(){var e=$("#nombre").val();var t=$("#apellidos").val();var n=$("#email").val();var r=$("#contra").val();var i=$("#dia").val();var s=$("#mes").val();var o=$("#any").val();var u=$("#code").val();var a=i+"/"+s+"/"+o;if(apellido_registro()&&email_registro()&&contrasenya_registro()&&nombre_registro()&&dia_registro()&&mes_registro()&&any_registro()){$.ajax({type:"POST",url:"php/controles/controlRegistro.php",data:{user:e,mail:n,pass:r,edad:a,apellidos:t,codeCaptcha:u}}).done(function(e){var t=$.parseJSON(e);if(!t.notice){alert("no ha podido registrarse, prueva con otro email")}else if(t.notice==3){alert("Codigo Captcha Mal escrito!!")}else{alert("Enhorabuena! Mira en tu correo y activalo!")}})}else{alert("Datos incorrectos")}}$(document).ready(function(){var e="";$(".text-input").focus(function(){e=$(this).val();if($(this).val()){$(this).val("")}else{$(this).val(e)}});$(".text-input").focusout(function(){if($(this).val()==""){$(this).val(e)}});$("#genCaptchaB").click(function(){$("#genCaptcha").html("<img src='php/controles/creaCaptcha.php?"+(new Date).getTime()+"'/><input type='text' id='code'/>")});$("#usuario").change(nombre_inicio);$("#password").change(contrasenya_inicio);$("#contra").change(contrasenya_registro);$("#nombre").change(nombre_registro);$("#apellidos").change(apellido_registro);$("#email").change(email_registro);$("#dia").change(dia_registro);$("#mes").change(mes_registro);$("#any").change(any_registro);$("#form-registro").hide();$("#registro").click(function(){$("#form-login").hide();$("#form-registro").show()});$("#login").click(function(){$("#form-login").show();$("#form-registro").hide()});$("#registrarse").click(registroBoton);$("#form-login").keypress(function(e){if(e.keyCode==13&&!e.shiftKey){$("#boton-login").click()}});$("#boton-login").click(function(){var e=$("#usuario").val();var t=$("#password").val();var n=$("#captchaDiv").val();var r=1;if(e==""){r=0}else if(t==""){r=0}else if(!validar_email(e)){r=0}if(r){$.ajax({type:"POST",url:"php/controles/controlLogin.php",data:{mail:e,pass:t,login:1,code:n}}).done(function(e){var t=$.parseJSON(e);if(t.notice==0)document.getElementById("no_logeo").innerHTML="No te has logeado";else if(t.notice==1)location.href="perfil.php";else if(t.notice==2)document.getElementById("no_logeo").innerHTML="No has activado tu cuenta , mira tu email";else if(t.notice==3)document.getElementById("captchaDiv").innerHTML=" <img src='php/controles/creaCaptcha.php?"+(new Date).getTime()+"'/><input type='text' id='code'/>";else if(t.notice==4)location.href="admin-panel.php"})}})});