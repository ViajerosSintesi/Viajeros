<?php
	require_once("./clases/UserClass.php");

	if(filter_has_var(INPUT_POST, "user") && filter_has_var(INPUT_POST, "mail") && filter_has_var(INPUT_POST, "pass") ){

		$newUser = new User();

		$mail = filter_input(INPUT_POST, "mail");
		$username = filter_input(INPUT_POST, "user");
		$password = filter_input(INPUT_POST, "pass");
		//$edad = filter_input(INPUT_POST, "edad");

		$newUser->setUsername($username);
		$newUser->setId($mail);
		$newUser->setPassword($password);
		$newUser->setCodActivacion(md5($mail));
		$newUser->setActivado(0);
		//$newUser->setEdad($edad);
		$returnLogin = $newUser->guardarUser();
		$newUser->enviaEmailConfirm();
		echo json_encode(array( "notice"=>$returnLogin));
		
		
	}
	


?>