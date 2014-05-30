<?php
/**
 * trata de si es pais o ciudad i mensajes, comentarios, preguntas....
 * 
 * en el caso de pais/ciudad, la valoracion es numerica : int
 * en el caso de mensajes, comentarios, preguntas,... es a favor o en contra :bool
 * 
 * tablas de valoraciones:
 *                            ciudad: valoracionciudad
 * 
 * */
 require_once("../clases/ValoracionClass.php");
 if(filter_has_var(INPUT_GET, "ciudad")&&filter_has_var(INPUT_GET, "verValorUsuario")){
      $userId = filter_input(INPUT_GET, "userId");
      $ciudad = filter_input(INPUT_GET, "ciudad");
      $valorCiudad = new Valoracion("valoracionciudad");
      $valorCiudad->setUser($userId);
      $valorCiudad->setObject($ciudad);
      $total = $valorCiudad->verValoracionDelUsuario();
      if($total<1) $total = 1;
       echo json_encode($total);
 }
 if(filter_has_var(INPUT_GET, "ciudad") && filter_has_var(INPUT_GET, "valorCiudad")){
      $userId = filter_input(INPUT_GET, "userId");
      $ciudad = filter_input(INPUT_GET, "ciudad");
      $valor = filter_input(INPUT_GET, "valorCiudad");

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
 if(filter_has_var(INPUT_GET, "ciudad")&&filter_has_var(INPUT_GET, "verValor")){
      
      $ciudad = filter_input(INPUT_GET, "ciudad");

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
            $total = $total/$numValores;   
      }
      echo json_encode($total);
 }
?>