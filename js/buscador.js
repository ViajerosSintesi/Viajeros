
function buscador(request, response){
      var ciudad = request.term;
      var dataEnvio = {"nombreCiudadB": ciudad, "buscar": 1};
      $.getJSON("php/controles/controlCiudad.php",dataEnvio ,function(data){
            var availableTags =[];
			
            for(var i = 0; i<data.length;i++){
                  
				  
                  if(data[i].idPais){
                   $("#id").val("ciudad.php?ciudad="+data[i]._id.$id);
                   availableTags.push(data[i].ciudad+" - "+data[i].pais);
                  }
                  else{
                   $("#id").val("pais.php?pais="+data[i]._id.$id);
                   availableTags.push(data[i].pais);
                  }
				  
				  
            }
            response(availableTags);
      });
      
}