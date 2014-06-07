<?php
	require_once("../clases/UserClass.php");

	if(filter_has_var(INPUT_POST, "user") && filter_has_var(INPUT_POST, "mail") && filter_has_var(INPUT_POST, "pass") ){
            session_start();
		$newUser = new User();

		$mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
		$username = filter_input(INPUT_POST, "user", FILTER_SANITIZE_STRING);
		$password = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_STRING);
		$edad = filter_input(INPUT_POST, "edad");
		$apellidos =  filter_input(INPUT_POST, "apellidos",FILTER_SANITIZE_STRING);
		$code =  filter_input(INPUT_POST, "codeCaptcha");
            
		$newUser->setUsername($username);
		$newUser->setApellidos($apellidos);
		$newUser->setId($mail);
		$newUser->setPassword($password);
		$newUser->setCodActivacion($mail);
		$newUser->setActivado(0);
		$newUser->setEdad($edad);
		if(isset($_FILES["imgPerfil"])){
                  $user->ponerImgPerfil($_FILES["imgPerfil"]);
            }
		//$newUser->setEdad($edad);
	
		if($_SESSION["captcha"] != $code){
		      $returnReg = 3;
		} else{
      		$returnReg = $newUser->guardarUser();
      	      #------->>>>>>>>>>>>>>>>>>>imposible enviar email
      		if($returnReg) $newUser->enviaEmailConfirm();
		}
	
		echo json_encode(array( "notice"=>$returnReg));
		
		
	}
	if(filter_has_var(INPUT_GET, "verificar")){
	      $codActivacion = filter_input(INPUT_GET, "verificar");
	      
	      $email = base64_decode($codActivacion);
	      //echo $email;
	      $user = new User();
	      $user->setId($email);
	      $user->cogeValoresSegunId();
	      
	      
	      $user->activarUser();
	      
	      header("location:../../index.php?ref=1");
	      
	}


?>