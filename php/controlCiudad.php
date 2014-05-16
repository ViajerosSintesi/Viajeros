<?php


	if(filter_has_var(INPUT_POST, "nombreCiu")){
            require_once("./clases/CiudadClass.php");
		$newciudad = new ciudad();
		$nombre = filter_input(INPUT_POST, "ciudad");
		
	}
	
	if(filter_has_var(INPUT_POST, "nombreCiudad") && filter_has_var(INPUT_POST, "buscar")){
	     require_once("./clases/ClassMongoClient.php");
	     $ciudad = filter_input(INPUT_POST, "nombreCiudad");
	     $mongo = new DBMongo("ciudades");
	     $regexObj = new MongoRegex("/".$ciudad."/"); 
	     $query = array("nombre" => $regexObj);
	     $todasciudades = $mongo->findCollection($query);
	     echo json_encode($todasciudades);
	}
	


?>