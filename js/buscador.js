
function buscador(){
      var ciudad = $(this).val();
      var data = {"nombreCiudad": ciudad, "buscar": 1};
      $.getJSON("php/controlCiudad.php",data ,function(){
            console.log(data);
      });
      
}