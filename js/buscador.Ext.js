
function buscador(request, response){
      var ciudad = request.term;
      var dataEnvio = {"nombreCiudadB": ciudad, "buscar": 1};
      $.getJSON("php/controles/controlCiudad.php",dataEnvio ,function(data){
            var availableTags =[];
		//if(data.length >0){	
            for(var i = 0; i<data.length;i++){
                  
			if(data)	  
                  if(data[i].idPais){
                        $("#id").val("ciudad.php?ciudad="+data[i]._id.$id);
                        availableTags.push(data[i].ciudad+" - "+data[i].pais);
                  }else if(data[i].idCiudad){
                        $("#id").val("pais.php?pais="+data[i]._id.$id);
                        availableTags.push(data[i].pais);
                  }else{
                        $("#id").val("perfil.php?user="+data[i].id);
                        availableTags.push(data[i].username);
                  }
				  
				  
            }
		/*}else{
		      $("#id").val("crearSitio.php?sitio="+ request.term);
		      availableTags.push("crear perfil de "+ request.term+"?");
		}*/
            response(availableTags);
      });
      
}