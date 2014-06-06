<?php

session_start();
require_once("../clases/CaptchaClass.php");
//create captcha
	$captcha = new Captcha(120, 70, 6);
	#colores
	$captcha->setBackColor(254,254,254);
	$captcha->setTextColor(254,0,0);
	$captcha->setNoiseColor(254,0,0);
	
	#crear colores
	$captcha->aceptarColors();

	#ruido
	$captcha->setNumDots(100);
	$captcha->setNumLines(30);
	#fuente
	$captcha->setFont('../../css/monofont.ttf');

	#crear codigo
	//$captcha->crearCode();
	
	$captcha->creaCaptcha();
	#guardar code en session
	
	
	/*echo $captcha->getCode()."<br>";
	echo $captcha->getSizeFont()."<br>";
	print_r( $captcha->getBackColor());
	print_r( $captcha->getNoiseColor());
	print_r( $captcha->getTextColor());
	echo $captcha->getFont()."<br>";^*/


	#crear ruido
	//$captcha->createNoise();

	#crear texto
	//$captcha->createText();

	#crear jpeg i devolver imagen
	//imagedestroy($captcha->getImage());
	$_SESSION["captcha"] = $captcha->getCode();
	$captcha->returnImage();
	
?>