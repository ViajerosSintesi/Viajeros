


function enviarValoracion(tipo, valor, user, object){
      switch(tipo){
            case 'comment': 
                        var dataEnvio = {"userId": user, 
                                         "coment": object, 
                                         "valorComent": valor};
                        $.getJSON("php/controles/controlValoracionComent.php",
                                    dataEnvio, function(data){
                                    console.log(data);
                                    });
                        break;
            case 'img':
                  var imgId = object;
                  var userId = user;

                  var dataEnvio = {"valorimg": valor, "imagenId": imgId, "userId": userId};
                  $.getJSON('php/controles/controlValoracionImg.php', dataEnvio, function(data){
                        console.log(data);
                  });
                  break;
            case 'pregunta': 
                        var dataEnvio = {"userId": user, 
                                         "pregunta": object, 
                                         "valorPregunta": valor};
                        $.getJSON("php/controles/controlValoracionPregunta.php",
                                    dataEnvio, function(data){
                                    console.log(data);
                                    });
                        break;
            case 'respuesta': 
                        var dataEnvio = {"userId": user, 
                                         "coment": object, 
                                         "valorComent": valor};
                        $.getJSON("php/controles/controlValoracionComent.php",
                                    dataEnvio, function(data){
                                    console.log(data);
                                    });
                        break;
            default: break;
      }
}