<?php
	require_once("./clases/UserClass.php");

	if(filter_has_var(INPUT_POST, "user") && filter_has_var(INPUT_POST, "mail") && filter_has_var(INPUT_POST, "pass") && filter_has_var(INPUT_POST, "edad")){

		$newUser = new User();

		$mail = filter_input(INPUT_POST, "mail");
		$username = filter_input(INPUT_POST, "user");
		$password = filter_input(INPUT_POST, "pass");
		$edad = filter_input(INPUT_POST, "edad");

		$newUser->setUsername($username);
		$newUser->setId($mail);
		$newUser->setPassword($password);
		$newUser->setEdad($edad);
		$newUser->guardarUser();
	}
	


?>