function buscador(e,t){var n=e.term;var r={nombreCiudadB:n,buscar:1};$.getJSON("php/controles/controlCiudad.php",r,function(e){var n=[];for(var r=0;r<e.length;r++){if(e)if(e[r].idPais){$("#id").val("ciudad.php?ciudad="+e[r]._id.$id);n.push(e[r].ciudad+" - "+e[r].pais)}else{$("#id").val("pais.php?pais="+e[r]._id.$id);n.push(e[r].pais)}}t(n)})}