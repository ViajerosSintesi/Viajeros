<?php

/**
 * codigos: 
 *          0: no votado
 *          1: votado negativamente
 *          2: votado positivamente
 * 
 * */
 require_once("../clases/ValoracionClass.php");


/**
* userID: id del usuario
* imagenID: id del comentario a ver la valoracion
* valorimg: valor a insertar
*
* inserta una nueva valoracion a la imagen por el user
*
* devuelve en formato JSONsi lo ha conseguido
**/
  if(filter_has_var(INPUT_GET, "imagenId") && filter_has_var(INPUT_GET, "valorimg")){
      $userId = filter_input(INPUT_GET, "userId", FILTER_SANITIZE_EMAIL);
      $imagenId = filter_input(INPUT_GET, "imagenId", FILTER_SANITIZE_STRING);
      $valor = filter_input(INPUT_GET, "valorimg", FILTER_SANITIZE_STRING);

      $valorimg = new Valoracion("valoracionimg");
      
      $valorimg->setUser($userId);
      $valorimg->setObject($imagenId);
      $valorimg->setValor($valor);
      //echo "<pre>";
      //var_dump($valorComent);
      echo json_encode($valorimg->insertValoracion(false));
 }


/**
* userID: id del usuario
* img: id del comentario a ver la valoracion
* verValor: valor a insertar
*
* 
* devuelve en formato JSON los valores de la imagen como el valor que el usuario dado le dio a la imagen
**/
 if(filter_has_var(INPUT_GET, "img")&&filter_has_var(INPUT_GET, "verValor")){
      
      $imagenId = filter_input(INPUT_GET, "img", FILTER_SANITIZE_STRING);
      $userId = filter_input(INPUT_GET, "userId", FILTER_SANITIZE_EMAIL);
      $valorImg = new Valoracion("valoracionimg", FILTER_SANITIZE_STRING);
      
      $valorImg->setObject($imagenId);
      $valoraciones = $valorImg->verValoraciones();
      $valImg["valorNeg"]=0;
      $valImg["valorPos"]=0;
      //var_dump($valoraciones);
      for($x = 0; $x<count($valoraciones); $x++){
            if($valoraciones[$x]["valor"] == 1) $valImg["valorNeg"]++;
            elseif($valoraciones[$x]["valor"] == 2)$valImg["valorPos"]++; 
      }
      
      $valorImg->setUser($userId);
      $total["valorUsu"] = $valorImg->verValoracionDelUsuario();
      $total["valores"] = $valImg;
      echo json_encode($total);
 }

?>