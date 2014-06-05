<?php

require_once("../clases/ValoracionClass.php");
require_once("../clases/PreguntaClass.php");
require_once("../clases/UserClass.php");
  
if(filter_has_var(INPUT_GET, "ciudad") && filter_has_var(INPUT_GET, "verPreguntas")){
  $ciudad = filter_input(INPUT_GET, "ciudad");
  $userId = filter_input(INPUT_GET, "userId");
  $tipo = filter_input(INPUT_GET, "verPreguntas");
  $preguntaCiudad = new Pregunta("pregunta".$tipo);
  
  $preguntaCiudad->setIdSitio($ciudad);
  $preguntas = $preguntaCiudad->devolverDelSitio($tipo);
  
  $valoracionPregunta = new Valoracion("valoracionpregunta");
  $valoracionPregunta->setUser($userId);
  $user = new User();
  for($i=0;$i<count($preguntas);$i++){
      $valoracionPregunta->setObject($preguntas[$i]["_id"]->{'$id'});
      $valoraciones = $valoracionPregunta->verValoraciones();
      $preguntas[$i]["valorNeg"]=0;
      $preguntas[$i]["valorPos"]=0;
      
      for($x = 0; $x<count($valoraciones); $x++){
            if($valoraciones[$x]["valor"] == 1) $preguntas[$i]["valorNeg"]++;
            elseif($valoraciones[$x]["valor"] == 2)$preguntas[$i]["valorPos"]++; 
      }
      $preguntas[$i]["valorDelUser"] = $valoracionPregunta->verValoracionDelUsuario(); 
      $user->setId($preguntas[$i]["idUsu"]);
      $user->cogeValoresSegunId();
      $preguntas[$i]["nombreDelUser"] = $user->getUsername();
      $preguntas[$i]["imgPerfilUser"] = $user->getImgPerfil();
  }
  
  //echo "<pre>";
  //var_dump($preguntas);
  
  echo json_encode($preguntas);
      
}

if(filter_has_var(INPUT_GET,"ciudad")&& filter_has_var(INPUT_GET, "insertarPregunta")){
      $ciudad = filter_input(INPUT_GET, "ciudad");
      $userId = filter_input(INPUT_GET, "userId");
      $tipo = filter_input(INPUT_GET, "insertarPregunta");
      $preguntaText = filter_input(INPUT_GET, "pregunta");
      $data = filter_input(INPUT_GET, "fecha");
      $pregunta= new Pregunta("pregunta".$tipo);
      
      $pregunta->setUser($userId);
      $pregunta->setIdSitio(new MongoId($ciudad));
      $pregunta->setPregunta($preguntaText);
      $pregunta->setFecha($data);
      echo json_encode($pregunta->insertarPregunta($tipo));
}

?>