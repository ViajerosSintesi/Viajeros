<?php

/**
 * archivo que crea un captcha lo retorna como archivo .jpg para ser mostrado
 * 
 * inicia una variable de sesion con el codigo del captcha
 * */

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

	$captcha->creaCaptcha();
	#guardar code en session

	$_SESSION["captcha"] = $captcha->getCode();
	$captcha->returnImage();
	
?>