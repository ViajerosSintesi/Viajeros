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
 require_once("../clases/ValoracionClass.php");
 if(filter_has_var(INPUT_GET, "pais")&&filter_has_var(INPUT_GET, "verValorUsuario")){
      $userId = filter_input(INPUT_GET, "userId");
      $pais = filter_input(INPUT_GET, "pais");
      $valorPais = new Valoracion("valoracionpais");
      $valorPais->setUser($userId);
      $valorPais->setObject($pais);
      $total = $valorPais->verValoracionDelUsuario();
      if($total<1) $total = 1;
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
      if($valorPais->insertValoracion(false)){
            header("Location:../../pais.php?pais=".$pais);
      }
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
      if($numValores != 0){
            for($i=0;$i<$numValores;$i++)
                  $total +=$valores[$i]["valor"];
         if($total != 0)
            $total = round($total/$numValores,1,PHP_ROUND_HALF_UP);  
      }
      
      echo json_encode($total);
      
 }
?>