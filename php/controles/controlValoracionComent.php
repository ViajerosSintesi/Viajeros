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
 
if(filter_has_var(INPUT_GET, "coment")&&filter_has_var(INPUT_GET, "verValorUsuario")){
      $userId = filter_input(INPUT_GET, "userId");
      $coment = filter_input(INPUT_GET, "coment");
      $valorComent = new Valoracion("valoracioncoment");
      $valorComent->setUser($userId);
      $valorComent->setObject($coment);
      $total = $valorComent->verValoracionDelUsuario();
      echo json_encode($total);
 }
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
 if(filter_has_var(INPUT_GET, "coment")&&filter_has_var(INPUT_GET, "verValor")){
      
      $coment = filter_input(INPUT_GET, "coment");

      $valorComent = new Valoracion("valoracioncoment");
      
      $valorComent->setObject($coment);
      $valores = $valorComent->verValoraciones();
      
      echo json_encode($valores);
 }
?>