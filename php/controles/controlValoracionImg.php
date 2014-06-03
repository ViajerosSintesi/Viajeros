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
 
if(filter_has_var(INPUT_GET, "img")&&filter_has_var(INPUT_GET, "verValorUsuario")){
      $userId = filter_input(INPUT_GET, "userId");
      $imagenId = filter_input(INPUT_GET, "img");
      $valorImg = new Valoracion("valoracioncoment");
      $valorImg->setUser($userId);
      $valorImg->setObject($imagenId);
      $total = $valorImg->verValoracionDelUsuario();
      echo json_encode($total);
 }
 if(filter_has_var(INPUT_GET, "img") && filter_has_var(INPUT_GET, "valorimg")){
      $userId = filter_input(INPUT_GET, "userId");
      $imagenId = filter_input(INPUT_GET, "imagenId");
      $valor = filter_input(INPUT_GET, "valorimg");

      $valorimg = new Valoracion("valoracionimg");
      
      $valorimg->setUser($userId);
      $valorimg->setObject($imagenId);
      $valorimg->setValor($valor);
      //echo "<pre>";
      //var_dump($valorComent);
      echo json_encode($valorimg->insertValoracion(false));
 }
 if(filter_has_var(INPUT_GET, "img")&&filter_has_var(INPUT_GET, "verValor")){
      
      $imagenId = filter_input(INPUT_GET, "img");

      $valorImg = new Valoracion("valoracionimg");
      
      $valorImg->setObject($imagenId);
      $valores = $valorImg->verValoraciones();
      
      echo json_encode($valores);
 }

?>