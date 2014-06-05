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
 
if(filter_has_var(INPUT_GET, "pregunta")&&filter_has_var(INPUT_GET, "verValorUsuario")){
      $userId = filter_input(INPUT_GET, "userId");
      $pregunta = filter_input(INPUT_GET, "pregunta");
      $valorPregunta = new Valoracion("valoracionpregunta");
      $valorPregunta->setUser($userId);
      $valorPregunta->setObject($pregunta);
      $total = $valorPregunta->verValoracionDelUsuario();
      echo json_encode($total);
 }
 if(filter_has_var(INPUT_GET, "pregunta") && filter_has_var(INPUT_GET, "valorPregunta")){
      $userId = filter_input(INPUT_GET, "userId");
      $pregunta = filter_input(INPUT_GET, "pregunta");
      $valor = filter_input(INPUT_GET, "valorPregunta");

      $valorPregunta = new Valoracion("valoracionpregunta");
      
      $valorPregunta->setUser($userId);
      $valorPregunta->setObject($pregunta);
      $valorPregunta->setValor($valor);
      //echo "<pre>";
      //var_dump($valorPregunta);
      echo json_encode($valorPregunta->insertValoracion(false));
 }
 if(filter_has_var(INPUT_GET, "pregunta")&&filter_has_var(INPUT_GET, "verValor")){
      
      $pregunta = filter_input(INPUT_GET, "pregunta");

      $valorPregunta = new Valoracion("valoracionpregunta");
      
      $valorPregunta->setObject($pregunta);
      $valores = $valorPregunta->verValoraciones();
      
      echo json_encode($valores);
 }
?>