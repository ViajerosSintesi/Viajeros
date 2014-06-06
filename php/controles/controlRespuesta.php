<?php

require_once("../clases/ValoracionClass.php");
require_once("../clases/RespuestaClass.php");
require_once("../clases/UserClass.php");
  
if(filter_has_var(INPUT_GET, "pregunta") && filter_has_var(INPUT_GET, "verRespuestas")){
  $pregunta = filter_input(INPUT_GET, "pregunta");
  $userId = filter_input(INPUT_GET, "userId");
  $tipo = filter_input(INPUT_GET, "verRespuestas");
  $respuestaCiudad = new Respuesta("respuesta".$tipo);
  
  $respuestaCiudad->setIdSitio($pregunta);
  $respuestas = $respuestaCiudad->devolverDeLaPregunta($tipo);
  
  $valoracionRespuesta = new Valoracion("valoracionrespuesta");
  $valoracionRespuesta->setUser($userId);
  $user = new User();
  for($i=0;$i<count($respuestas);$i++){
      $valoracionRespuesta->setObject($respuestas[$i]["_id"]->{'$id'});
      $valoraciones = $valoracionRespuesta->verValoraciones();
      $respuestas[$i]["valorNeg"]=0;
      $respuestas[$i]["valorPos"]=0;
      
      for($x = 0; $x<count($valoraciones); $x++){
            if($valoraciones[$x]["valor"] == 1) $respuestas[$i]["valorNeg"]++;
            elseif($valoraciones[$x]["valor"] == 2)$respuestas[$i]["valorPos"]++; 
      }
      $respuestas[$i]["valorDelUser"] = $valoracionRespuesta->verValoracionDelUsuario(); 
      $user->setId($respuestas[$i]["idUsu"]);
      $user->cogeValoresSegunId();
      $respuestas[$i]["nombreDelUser"] = $user->getUsername();
      $respuestas[$i]["imgPerfilUser"] = $user->getImgPerfil();
  }
  
  //echo "<pre>";
  //var_dump($respuestas);
  
  echo json_encode($respuestas);
      
}

if(filter_has_var(INPUT_GET,"pregunta")&& filter_has_var(INPUT_GET, "insertarRespuesta")){
      $pregunta = filter_input(INPUT_GET, "pregunta");
      $userId = filter_input(INPUT_GET, "userId");
      $tipo = filter_input(INPUT_GET, "insertarRespuesta");
      $respuestaText = filter_input(INPUT_GET, "respuesta");
      $data = filter_input(INPUT_GET, "fecha");
      $respuesta= new Respuesta("respuesta".$tipo);
      
      $respuesta->setUser($userId);
      $respuesta->setIdSitio(new MongoId($pregunta));
      $respuesta->setRespuesta($respuestaText);
      $respuesta->setFecha($data);
        $inserta = 0;
     if(filter_has_var(INPUT_COOKIE,"respuesta")){
            $numIntentos = filter_input(INPUT_COOKIE,"respuesta");
           
            if($numIntentos <4){
              $expire=time()+60*4;
              $inserta =1;
               setcookie("respuesta", $numIntentos+1, $expire);
            }
      }else{
            $expire=time()+60*4;
             setcookie("respuesta", 0, $expire);
      }
     
      if($inserta){
              echo json_encode($respuesta->insertarRespuesta($tipo));
      } else{
            echo json_encode(0);
      }
}

?>