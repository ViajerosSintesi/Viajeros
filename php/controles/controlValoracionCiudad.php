<?php
/**
 * trata de si es pais o ciudad i mensajes, comentarios, preguntas....
 * 
 * en el caso de pais/ciudad, la valoracion es numerica : int
 * en el caso de mensajes, comentarios, preguntas,... es a favor o en contra :bool
 * 
 * 
 * */
 require_once("../clases/ValoracionClass.php");

 /**
  * userID: id del usuario
  * ciudad: id de la ciudad a ver la valoracion
  *verValorUsuario: llamada a la funcion
  * 
  * devuelve en formato JSON la puntuacion que ha dado el usuario a la ciudad 
  * 
  */
 if(filter_has_var(INPUT_GET, "ciudad")&&filter_has_var(INPUT_GET, "verValorUsuario")){
      $userId = filter_input(INPUT_GET, "userId", FILTER_SANITIZE_EMAIL);
      $ciudad = filter_input(INPUT_GET, "ciudad", FILTER_SANITIZE_STRING);
      $valorCiudad = new Valoracion("valoracionciudad", FILTER_SANITIZE_STRING);
      $valorCiudad->setUser($userId);
      $valorCiudad->setObject($ciudad);
      $total = $valorCiudad->verValoracionDelUsuario();
      if($total<1) $total = 1;
       echo json_encode($total);
 }

 /**
  *  userID: id del usuario
  *  ciudad: id de la ciudad a ver la valoracion
  *  valorCiudad: llamada a la funcion
  *
  * inserta una valoracion de una ciudad y un usuario, si existe lo sobrescribe
  *
  * no devuelve nada, refresca la pagina ciudad
  */
 if(filter_has_var(INPUT_GET, "ciudad") && filter_has_var(INPUT_GET, "valorCiudad")){
      $userId = filter_input(INPUT_GET, "userId", FILTER_SANITIZE_EMAIL);
      $ciudad = filter_input(INPUT_GET, "ciudad", FILTER_SANITIZE_STRING);
      $valor = filter_input(INPUT_GET, "valorCiudad", FILTER_SANITIZE_STRING);

      $valorCiudad = new Valoracion("valoracionciudad");
      
      $valorCiudad->setUser($userId);
      $valorCiudad->setObject($ciudad);
      $valorCiudad->setValor($valor);
      //echo "<pre>";
      //var_dump($valorCiudad);
      if($valorCiudad->insertValoracion(false)){
             header("Location:../../ciudad.php?ciudad=".$ciudad);
      }
 }

 /**
  * 
  * ciudad: id de la ciudad a ver la valoracion
  * verValor: llamada a la funcion
  *
  * dada la ciudad, calcula la media entre la gente que lo ha votado y su nota
  *
  * la respuesta es el propio calculo en formato JSON
  */
 if(filter_has_var(INPUT_GET, "ciudad")&&filter_has_var(INPUT_GET, "verValor")){
      
      $ciudad = filter_input(INPUT_GET, "ciudad", FILTER_SANITIZE_STRING);

      $valorCiudad = new Valoracion("valoracionciudad");
      
      $valorCiudad->setObject($ciudad);
      $valores = $valorCiudad->verValoraciones();
      
      $numValores = count($valores);
      $total=0;
      //echo "<pre>";
      //var_dump($valores);
      if($numValores != 0){
            for($i=0;$i<$numValores;$i++)
                  $total +=$valores[$i]["valor"];
         if($total != 0)
            $total = round($total/$numValores,1,PHP_ROUND_HALF_UP);  
      }
      echo json_encode($total);
 }
?>