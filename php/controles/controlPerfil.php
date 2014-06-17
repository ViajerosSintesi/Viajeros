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
	      $user->setId(base64_decode(filter_input(INPUT_GET, "userId"), FILTER_SANITIZE_EMAIL));
	      $user->cogeValoresSegunId();
	      $userArray=array(
	                  'nombre'=> $user->getUsername(),
	                  'apellidos'=> $user->getApellidos(),
	                  'email'=> base64_decode(base64_decode($user->getId())),
	                  'edad'=> $user->getEdad(),
	                  'imgPerfil'=>$user->getImgPerfil(),
	                  'privacidad'=>$user->getPrivado()
	            );
	      echo json_encode($userArray);
	}
      
      
?>