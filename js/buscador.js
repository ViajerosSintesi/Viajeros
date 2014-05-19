
function buscador(request, response){
      var ciudad = request.term;
      var dataEnvio = {"nombreCiudad": ciudad, "buscar": 1};
      $.getJSON("php/controlCiudad.php",dataEnvio ,function(data){
           
            
            var availableTags =[];
           for(var i = 0; i<data.length;i++){
                  availableTags.push(data[i].nombre+" - "+ data[i].pais);
            }
            response(availableTags);
      });
      
}