<?php

 
require_once("../clases/ValoracionClass.php");
require_once("../clases/CommentClass.php");
require_once("../clases/UserClass.php");
/**
 * ciudad: nombre de la ciudad/pais
 * verComments: tipo si es ciudad o pais
 * user: usuario
 *
 * se le pasa el nombre de la ciudad/pais, el tipo  y el usuario. 
 * devuelve un array con toda la informacion de los comentarios del sitio
 *
 * devuelve la valoracion del comentario en formato JSON
 */
if(filter_has_var(INPUT_GET, "ciudad") && filter_has_var(INPUT_GET, "verComments")){
  $ciudad = filter_input(INPUT_GET, "ciudad");
  $userId = filter_input(INPUT_GET, "userId");
  $tipo = filter_input(INPUT_GET, "verComments");
  $commentCiudad = new Comment("coment".$tipo);
  
  $commentCiudad->setIdSitio($ciudad);
  $comentarios = $commentCiudad->devolverDelSitio($tipo);
  
  $valoracionComent = new Valoracion("valoracioncoment");
  $valoracionComent->setUser($userId);
  $user = new User();
  for($i=0;$i<count($comentarios);$i++){
      $valoracionComent->setObject($comentarios[$i]["_id"]->{'$id'});
      $valoraciones = $valoracionComent->verValoraciones();
      $comentarios[$i]["valorNeg"]=0;
      $comentarios[$i]["valorPos"]=0;
      
      for($x = 0; $x<count($valoraciones); $x++){
            if($valoraciones[$x]["valor"] == 1) $comentarios[$i]["valorNeg"]++;
            elseif($valoraciones[$x]["valor"] == 2)$comentarios[$i]["valorPos"]++; 
      }
      $comentarios[$i]["valorDelUser"] = $valoracionComent->verValoracionDelUsuario(); 
      $user->setId($comentarios[$i]["idUsu"]);
      $user->cogeValoresSegunId();
      $comentarios[$i]["nombreDelUser"] = $user->getUsername();
      $comentarios[$i]["imgPerfilUser"] = $user->getImgPerfil();
  }

  echo json_encode($comentarios);
      
}

/**
 * ciudad: nombre de la ciudad donde se interta
 * insertarComment: el tipo,si es ciudad o pais
 * userId: el usuario que lo inserta
 * comentText_ texto del comentario
 * data: la fecha
 *
 * encargado de insertar el comentario en la BBDD
 *
 * comprueba que exista en SESSION el usuario->y que sea el mismo que entra como parametro
 *
 * crea una cookie con un contador de comentarios por tiempo, para que solo permita un comentario al minuto
 *
 *
 * devuelve si ha podido insertar true or false
 * 
 */
if(filter_has_var(INPUT_GET,"ciudad")&& filter_has_var(INPUT_GET, "insertarComent")){
      
      $ciudad = filter_input(INPUT_GET, "ciudad");
      $userId = filter_input(INPUT_GET, "userId");
      $tipo = filter_input(INPUT_GET, "insertarComent");
      $comentText = filter_input(INPUT_GET, "comentario");
      $data = filter_input(INPUT_GET, "fecha");
      $coment= new Comment("coment".$tipo);
      
      $coment->setUser($userId);
      $coment->setIdSitio(new MongoId($ciudad));
      $coment->setComentario($comentText);
      
      $coment->setFecha($data);
      $inserta = 0;
      session_start();
      if(isset($_SESSION["userId"])){
      	if($_SESSION["userId"] == $userId){
      		if(filter_has_var(INPUT_COOKIE,"coment")){
      			$numIntentos = filter_input(INPUT_COOKIE,"coment");
      			echo $numIntentos;

      			if($numIntentos <4){
      				$expire=time()+60*4;
      				$inserta =1;
      				setcookie("coment", $numIntentos+1, $expire);
      			}
      		}else{
      			$expire=time()+60*4;
      			setcookie("coment", 0, $expire);
      		}
      	}
      }
      if($inserta){
      	echo json_encode($coment->insertarComent($tipo));
      } else{
      	echo json_encode(0);
      }

}

?>
