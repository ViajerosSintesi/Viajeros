<?php
	require_once("./clases/UserClass.php");
	session_start();
	
	if(filter_has_var(INPUT_GET, "datosPerfil")){
	      $user = new User();
	      $user->setId(filter_input(INPUT_GET, "userId"));
	      $user->cogeValoresSegunId();
	      $userArray=array(
	                  'nombre'=> $user->getUsername(),
	                  'apellidos'=> $user->getApellidos(),
	                  'email'=> $user->getId(),
	                  'edad'=> $user->getEdad(),
	                  'imgPerfil'=>$user->getImgPerfil()
	            );
	      echo json_encode($userArray);
	}
      
      
?>