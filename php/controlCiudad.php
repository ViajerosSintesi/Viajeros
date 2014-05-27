<?php


	if(filter_has_var(INPUT_POST, "nombreCiu")){
            require_once("./clases/CiudadClass.php");
		$newciudad = new ciudad();
		$nombre = filter_input(INPUT_POST, "ciudad");
		
	}
	
	if(filter_has_var(INPUT_GET, "nombreCiudad") && filter_has_var(INPUT_GET, "buscar")){
	     require_once("./clases/ClassMongoClient.php");
	     $ciudad = filter_input(INPUT_GET, "nombreCiudad");
	     $mongo = new DBMongo("ciudad");
	     $regexObj = new MongoRegex("/".$ciudad."/"); 
	     $query = array("ciudad" => $regexObj);
	     $todasciudades = $mongo->findCollection($query);
	     echo json_encode($todasciudades);
	}
	


?>