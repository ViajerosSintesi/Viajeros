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
  * pais: id del pais a ver la valoracion
  *verValorUsuario: llamada a la funcion
  * 
  * devuelve en formato JSON la puntuacion que ha dado el usuario al pais
  * 
  */
 if(filter_has_var(INPUT_GET, "pais")&&filter_has_var(INPUT_GET, "verValorUsuario")){
      $userId = filter_input(INPUT_GET, "userId", FILTER_SANITIZE_EMAIL);
      $pais = filter_input(INPUT_GET, "pais", FILTER_SANITIZE_STRING);
      $valorPais = new Valoracion("valoracionpais");
      $valorPais->setUser($userId);
      $valorPais->setObject($pais);
      $total = $valorPais->verValoracionDelUsuario();
      if($total<1) $total = 1;
       echo json_encode($valorPais->verValoracionDelUsuario());
 }
  /**
  *  userID: id del usuario
  *  ciudad: id del pais a ver la valoracion
  *  valorCiudad: llamada a la funcion
  *
  * inserta una valoracion de un pais y un usuario, si existe lo sobrescribe
  *
  * no devuelve nada, refresca la pagina pais
  */
 if(filter_has_var(INPUT_GET, "pais") && filter_has_var(INPUT_GET, "valorPais")){
      $userId = filter_input(INPUT_GET, "userId", FILTER_SANITIZE_EMAIL);
      $pais = filter_input(INPUT_GET, "pais", FILTER_SANITIZE_STRING);
      $valor = filter_input(INPUT_GET, "valorPais", FILTER_SANITIZE_STRING);

      $valorPais = new Valoracion("valoracionpais");
      
      $valorPais->setUser($userId);
      $valorPais->setObject($pais);
      $valorPais->setValor($valor);
      //echo "<pre>";
      //var_dump($valorPais);
      if($valorPais->insertValoracion(false)){
            header("Location:../../pais.php?pais=".$pais);
      }
 }
  /**
  * 
  * pais: id de la pais a ver la valoracion
  * verValor: llamada a la funcion
  *
  * dada la pais, calcula la media entre la gente que lo ha votado y su nota
  *
  * la respuesta es el propio calculo en formato JSON
  */
 if(filter_has_var(INPUT_GET, "pais")&&filter_has_var(INPUT_GET, "verValor")){
      
      $pais = filter_input(INPUT_GET, "pais", FILTER_SANITIZE_STRING);

      $valorPais = new Valoracion("valoracionpais");
      
      $valorPais->setObject($pais);
      $valores = $valorPais->verValoraciones();
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