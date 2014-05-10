<?php
	require_once("./clases/UserClass.php");

	//if(filter_has_var(INPUT_POST, "user")){

		$newUser = new User();

		$mail = "mascarantitxema@gmail.com";
		$username = "txemens";
		$password = "h0lita";
		$edad = "24";

		$newUser->setUsername($username);
		$newUser->setId($mail);
		$newUser->setPassword($password);
		$newUser->setEdad($edad);

		$newUser->guardarUser();


	//}
	


?>