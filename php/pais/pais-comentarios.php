<?php
session_start();
include("../funciones.php");
if(isset($_GET['pais'])){
	$pais = $_GET['pais'];
}
?>
<html>
<head>
	<title></title>
	<!--<script src="js/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>-->
	
	<script src="js/cargaScript.js"></script>
	<script src="js/valoracion.js"></script>
	<script type="text/javascript">
            $(function(){
                  cargarComents();

            });
            
	      function cargarComents(){
	           var dataEnvio = {
	                        "ciudad": '<?php echo $pais;?>',
	                        "userId": "<?php echo $_SESSION['userId'];?>",
	                        "verComments":"Pais"
	                  }
	           $.getJSON("php/controles/controlComment.php", dataEnvio, function(data){
	             //console.log(data);
	             var htmlInsert = ""; 
	             for(var i = 0; i<data.length; i++){
                       htmlInsert +='<div class="coments">';
                        htmlInsert +='<div class="coment-up">';
                        htmlInsert +='<p>'+data[i].nombreDelUser+'</p>';
			      htmlInsert +='<p>'+data[i].comentario+'</p>';
			      htmlInsert +='<input type="hidden" id="idUsu'+i+'" value="<?php echo $_SESSION["userId"];?>"/>';
			      htmlInsert +='<input type="hidden" id="idComent'+i+'" value="'+data[i]._id['$id']+'"/>';
                        
		            htmlInsert +='</div>';
		            htmlInsert +='<div class="coment-down">';
			      htmlInsert +='<button title="me gusta" class="meGusta" id="coment-'+i+'"><span id="countPos'+i+'">'+data[i].valorPos+'</span><img src="img/hand_pro.png" ></button>';
			      htmlInsert +='<button title="no me gusta" class="noMeGusta" id="coment-'+i+'"><span id="countNeg'+i+'">'+data[i].valorNeg+'</span><img src="img/hand_contra.png" ></button>';
			      htmlInsert +='<button title="reportar abuso"><img src="img/hand_1.png" ></button>';
		            htmlInsert +='</div>';
		            htmlInsert +='</div>';
	             }
	            
      	      htmlInsert +='<div id="subirComent">';
      		htmlInsert +='<form action="#" method="post">';
      		htmlInsert +='<textarea id="areatexto" cols="80" rows="5"></textarea>';
      		htmlInsert +='<!-- <input type="submit" id="kiko" value="enviar"> -->';
      	      htmlInsert +='</form>';
                  htmlInsert +='</div>';
                  
	             $("#comentarios-pais").html(htmlInsert);
	             $(".meGusta").click(function(){
                        var id=$(this).attr("id");
                        var numComent = id[id.length-1];
                        //console.log(numComent);
                        var idUsu= $("#idUsu"+numComent).val();
                        var idComment= $("#idComent"+numComent).val();
                        enviarValoracion("comment", 2, idUsu, idComment);
                        cargarComents();
                  });
                  
                  $(".noMeGusta").click(function(){
                        var id=$(this).attr("id");
                        var numComent = id[id.length-1];
                        //console.log(numComent);
                        var idUsu= $("#idUsu"+numComent).val();
                        var idComment= $("#idComent"+numComent).val();
                        enviarValoracion("comment", 1, idUsu, idComment);
                        cargarComents();
                  });
	           }); 
	            
	      }
	</script>
</head>
<body>


<div id="comentarios-pais">
	
</div>
</body>
</html>