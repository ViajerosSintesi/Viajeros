<?php
require_once("../clases/UserClass.php");

/**
 * se lepasan todos los datos del registro y se insertan en la BBDD como nuevo usuario si no
 * existe
 *
 * se crea una variable de sesion con el id del usuario
 *
 * si existiese una img de perfil, la pondria
 *
 * una vez insertado envia un email con el codigo de verificacion
 * para que el usuario puedo activar la cuenta
 */
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
      	     
		if($returnReg) $newUser->enviaEmailConfirm();
	}
	
	echo json_encode(array( "notice"=>$returnReg));


}

/**
 * verificar : codigo de activacion
 *
 * se le pasa el codigo de verificacion que es el id codificacod
 * si existe, se activa
 */
if(filter_has_var(INPUT_GET, "verificar")){
	$codActivacion = filter_input(INPUT_GET, "verificar", FILTER_SANITIZE_STRING);

	$email = base64_decode($codActivacion);
	      //echo $email;
	$user = new User();
	$user->setId($email);
	$user->cogeValoresSegunId();


	$user->activarUser();

	header("location:../../index.php?ref=1");

}


?>