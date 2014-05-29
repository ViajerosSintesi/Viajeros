<?php
/**
 * trata de si es pais o ciudad i mensajes, comentarios, preguntas....
 * 
 * en el caso de pais/ciudad, la valoracion es numerica : int
 * en el caso de mensajes, comentarios, preguntas,... es a favor o en contra :bool
 * 
 * tablas de valoraciones:
 *                            pais: valoracionpais
 * 
 * */
 require_once("clases/ValoracionClass.php");
 if(filter_has_var(INPUT_GET, "pais")&&filter_has_var(INPUT_GET, "verValorUsuario")){
      $userId = filter_input(INPUT_GET, "userId");
      $pais = filter_input(INPUT_GET, "pais");
      $valorPais = new Valoracion("valoracionpais");
      $valorPais->setUser($userId);
      $valorPais->setObject($pais);

       echo json_encode($valorPais->verValoracionDelUsuario());
 }
 if(filter_has_var(INPUT_GET, "pais") && filter_has_var(INPUT_GET, "valorPais")){
      $userId = filter_input(INPUT_GET, "userId");
      $pais = filter_input(INPUT_GET, "pais");
      $valor = filter_input(INPUT_GET, "valorPais");

      $valorPais = new Valoracion("valoracionpais");
      
      $valorPais->setUser($userId);
      $valorPais->setObject($pais);
      $valorPais->setValor($valor);
      //echo "<pre>";
      //var_dump($valorPais);
      echo json_encode($valorPais->insertValoracion(false));
 }
 if(filter_has_var(INPUT_GET, "pais")&&filter_has_var(INPUT_GET, "verValor")){
      
      $pais = filter_input(INPUT_GET, "pais");

      $valorPais = new Valoracion("valoracionpais");
      
      $valorPais->setObject($pais);
      $valores = $valorPais->verValoraciones();
      $numValores = count($valores);
      $total=0;
      //echo "<pre>";
      //var_dump($valores);
      for($i=0;$i<$numValores;$i++)
            $total +=$valores[$i]["valor"];

      $total = $total/$numValores;
      echo json_encode($total);
      echo json_encode($valores);
 }
?>