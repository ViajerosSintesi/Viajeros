<?php
	require_once("../clases/UserClass.php");
	session_start();
	
	/**
	 * datosPErfil: llamada a la funcion
	 * userId: id del usuario a devolver informacion
	 *
	 * devuelve la informacion en formato JSON de los datos
	 * del usuario
	 */
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