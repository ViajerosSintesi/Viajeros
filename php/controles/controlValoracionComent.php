<?php
/**
 * codigos: 
 *          0: no votado
 *          1: votado negativamente
 *          2: votado positivamente
 * */
 
 
 require_once("../clases/ValoracionClass.php");
 
/**
* userID: id del usuario
* comment: id del comentario a ver la valoracion
* verValorUsuario: llamada a la funcion
*
* devuelve la valoracion que le ha puesto el usuario al comment
**/
 
if(filter_has_var(INPUT_GET, "coment")&&filter_has_var(INPUT_GET, "verValorUsuario")){
      $userId = filter_input(INPUT_GET, "userId");
      $coment = filter_input(INPUT_GET, "coment");
      $valorComent = new Valoracion("valoracioncoment");
      $valorComent->setUser($userId);
      $valorComent->setObject($coment);
      $total = $valorComent->verValoracionDelUsuario();
      echo json_encode($total);
 }


/**
* userID: id del usuario
* comment: id del comentario a ver la valoracion
* valorComent: valor a insertar
*
* inserta la valoracion del comentario heca por el usuario
* devuelve si lo ha podido realizar
**/
 if(filter_has_var(INPUT_GET, "coment") && filter_has_var(INPUT_GET, "valorComent")){
      $userId = filter_input(INPUT_GET, "userId");
      $coment = filter_input(INPUT_GET, "coment");
      $valor = filter_input(INPUT_GET, "valorComent");

      $valorComent = new Valoracion("valoracioncoment");
      
      $valorComent->setUser($userId);
      $valorComent->setObject($coment);
      $valorComent->setValor($valor);
      //echo "<pre>";
      //var_dump($valorComent);
      echo json_encode($valorComent->insertValoracion(false));
 }


/**
* comment: id del comentario a ver la valoracion
* verValor: llamada a la funcion
*
* devuelve todas las valoraciones que tiene el comentario en formato JSON
**/
 if(filter_has_var(INPUT_GET, "coment")&&filter_has_var(INPUT_GET, "verValor")){
      
      $coment = filter_input(INPUT_GET, "coment");

      $valorComent = new Valoracion("valoracioncoment");
      
      $valorComent->setObject($coment);
      $valores = $valorComent->verValoraciones();
      
      echo json_encode($valores);
 }
?>