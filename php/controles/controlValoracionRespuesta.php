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
 
if(filter_has_var(INPUT_GET, "respuesta")&&filter_has_var(INPUT_GET, "verValorUsuario")){
      $userId = filter_input(INPUT_GET, "userId");
      $respuesta = filter_input(INPUT_GET, "respuesta");
      $valorRespuesta = new Valoracion("valoracionrespuesta");
      $valorRespuesta->setUser($userId);
      $valorRespuesta->setObject($respuesta);
      $total = $valorRespuesta->verValoracionDelUsuario();
      echo json_encode($total);
 }
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
 if(filter_has_var(INPUT_GET, "respuesta")&&filter_has_var(INPUT_GET, "verValor")){
      
      $respuesta = filter_input(INPUT_GET, "respuesta");

      $valorRespuesta = new Valoracion("valoracionrespuesta");
      
      $valorRespuesta->setObject($respuesta);
      $valores = $valorRespuesta->verValoraciones();
      
      echo json_encode($valores);
 }
?>