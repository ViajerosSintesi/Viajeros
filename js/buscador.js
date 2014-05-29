
function buscador(request, response){
      var ciudad = request.term;
      var dataEnvio = {"nombreCiudad": ciudad, "buscar": 1};
      $.getJSON("php/controlCiudad.php",dataEnvio ,function(data){
            var availableTags =[];
			
           for(var i = 0; i<data.length;i++){
                  availableTags.push(data[i].ciudad+" - "+data[i].pais);
				  
				  if(data[i].idPais){
				  $("#id").val("ciudad.php?ciudad="+data[i]._id.$id);
				  }
				  else{
				  $("#id").val("pais.php?pais="+data[i]._id.$id);
				  }
				  
				  
            }
            response(availableTags);
      });
      
}