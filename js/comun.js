$(function(){

$("#buscar" ).autocomplete({
                  source: buscador,
                  select: function(){
                        var res = document.getElementById("id").value;
                        window.location=res;
                  }
            });
			
});