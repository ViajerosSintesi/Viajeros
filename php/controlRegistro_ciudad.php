<?php
	require_once("./clases/CiudadClass.php");

	if(filter_has_var(INPUT_POST, "nombre")){

		$newciudad = new ciudad();


		$nombre = filter_input(INPUT_POST, "ciudad");


		$newciudad->setnombre($nombre);
		$newciudad->setId();
		$newciudad->setcoordenadax($coordenadax);
		$newciudad->setcoordenaday($coordenaday);


		$returnCiudad = $newciudad->guardarciudades();
		echo json_encode(array( "notice"=>$returnCiudad));
		
		
	}
	


?>