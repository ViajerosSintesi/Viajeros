<?php
/**
 * codigos: 
 *          0: no votado
 *          1: votado negativamente
 *          2: votado positivamente
 * 
 * 
 * 
 * */
 require_once("../clases/ValoracionClass.php");
 /**
* userID: id del usuario
* respuesta: id de la respuesta a ver la valoracion
* verValorUsuario: llamada a la funcion
*
* devuelve la valoracion que le ha puesto el usuario a la respuesta
**/
if(filter_has_var(INPUT_GET, "respuesta")&&filter_has_var(INPUT_GET, "verValorUsuario")){
      $userId = filter_input(INPUT_GET, "userId");
      $respuesta = filter_input(INPUT_GET, "respuesta");
      $valorRespuesta = new Valoracion("valoracionrespuesta");
      $valorRespuesta->setUser($userId);
      $valorRespuesta->setObject($respuesta);
      $total = $valorRespuesta->verValoracionDelUsuario();
      echo json_encode($total);
 }
 

/**
* userID: id del usuario
* respuesta: id de la respuesta a ver la valoracion
* valorRespuesta: valor a insertar
*
* inserta la valoracion de la repuesta heca por el usuario
* devuelve si lo ha podido realizar
**/
 if(filter_has_var(INPUT_GET, "respuesta") && filter_has_var(INPUT_GET, "valorRespuesta")){
      $userId = filter_input(INPUT_GET, "userId");
      $respuesta = filter_input(INPUT_GET, "respuesta");
      $valor = filter_input(INPUT_GET, "valorRespuesta");

      $valorRespuesta = new Valoracion("valoracionrespuesta");
      
      $valorRespuesta->setUser($userId);
      $valorRespuesta->setObject($respuesta);
      $valorRespuesta->setValor($valor);
      //echo "<pre>";
      //var_dump($valorRespuesta);
      echo json_encode($valorRespuesta->insertValoracion(false));
 }
 
 
/**
* respuesta: id de la respuesta a ver la valoracion
* verValor: llamada a la funcion
*
* devuelve todas las valoraciones que tiene la respuesta en formato JSON
**/
 if(filter_has_var(INPUT_GET, "respuesta")&&filter_has_var(INPUT_GET, "verValor")){
      
      $respuesta = filter_input(INPUT_GET, "respuesta");

      $valorRespuesta = new Valoracion("valoracionrespuesta");
      
      $valorRespuesta->setObject($respuesta);
      $valores = $valorRespuesta->verValoraciones();
      
      echo json_encode($valores);
 }
?>