


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
            case 'img':break;
            default: break;
      }
}