<?php
	require_once("./clases/CiudadClass.php");

	if(filter_has_var(INPUT_POST, "nombre")){

		$newciudad = new ciudad();


		$nombre = filter_input(INPUT_POST, "ciudad");


		$newciudad->setnombre($nombre);
		$newciudad->setId();
		$newciudad->setpoblacion($poblacion);
		$newciudad->setlengua($lengua);
		$newciudad->setusuarios_id($usuarios_id);

		$returnLogin = $newciudad->guardarUser();
		echo json_encode(array( "notice"=>$returnLogin));
		
		
	}
	


?>