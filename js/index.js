$(document).ready(function(){
    $("#form-registro").hide();
    $("#registro").click(function(){
        $("#form-login").hide();
        $("#form-registro").show();
        
    });
    $("#login").click(function(){
        $("#form-login").show();
        $("#form-registro").hide();
    });
    $("#registrarse").click(registroBoton);
    
    $("#boton-login").click(function(){
          var mail = $("#usuario").val();
          var pass = $("#password").val();
          var pasa = 1;
          if(mail == ""){
                //$("#emailLog").addClass("has-error");
                pasa = 0;
          }else if(pass == ""){
                //$("#passLog").addClass("has-error");
                pasa = 0;
          }else if(!validar_email(mail)){
                pasa = 0;
          }
          if(pasa){
              $.ajax({
                  type: "POST",
                  url: "php/controlLogin.php",
                  data: {"mail":mail,"pass":pass, "login":1}
              })
              .done(function(data){
                      var not = $.parseJSON(data);
                   if(!not.notice){
                       alert("no te has logueado");
                   }
                   if(not.notice == 1){
                         location.href="perfil.php";
                   }
                   if(not.notice == 2){
                         alert("no has activado la cuenta, mira en tu email");
                   }
              });
          }
    });
    
    
 
});
      /*
    $("#repeatPassReg").change(function(){
     if($(this).val() != $("#passReg").val()){
        $("#divrepPass").addClass("has-error");  
     }else{
         $("#divrePass").removeClass("has-error");  
     }
    });
    */
function validar_email(valor){
      // creamos nuestra regla con expresiones regulares.
      var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
      // utilizamos test para comprobar si el parametro valor cumple la regla
      if(filter.test(valor))
            return true;
      else
            return false;
}


 function registroBoton(){
    var user = $("#nombre").val();
    var apellidos = $("#apellidos").val();
    var mail = $("#email").val();
    var pass = $("#password").val();
    var dia = $("#dia").val();
    var mes = $("#mes").val();
    var anio = $("#año").val();
    
    var fecha = dia+"/"+mes+"/"+anio;
    if(mail== ''){
          alert("El email no es valido");
      }else if(validar_email(mail)){
            $.ajax({
                  type: "POST",
                  url: "php/controlRegistro.php",
                  data: {"user":user, "mail":mail,"pass":pass, "edad":fecha, "apellidos":apellidos }
              })
              .done(function(data){
                    var not = $.parseJSON(data);
                   if(!not.notice){
                       alert("no ha podido registrarse, prueva con otro email");
                   }else{
                         alert("Enhorabuena! Mira en tu correo y activalo!");
                   }
              });
      }else{
            alert("El email no es valido");
      }
    
    };