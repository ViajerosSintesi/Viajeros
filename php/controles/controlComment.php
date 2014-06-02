<?php

 
require_once("../clases/ValoracionClass.php");
require_once("../clases/CommentClass.php");
require_once("../clases/UserClass.php");
  
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
  
  //echo "<pre>";
  //var_dump($comentarios);
  
  echo json_encode($comentarios);
      
}

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
      
      echo json_encode($coment->insertarComent($tipo));
}

?>
