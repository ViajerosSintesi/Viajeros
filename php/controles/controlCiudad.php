<?php


	if(filter_has_var(INPUT_GET, "nombreCiudad")){
            require_once("../clases/CiudadClass.php");
		$ciudadC = new Ciudad();
		$id = filter_input(INPUT_GET, "nombreCiudad");
	      $ciudadC->setId($id);
	      $ciudadC->cogeValoresSegunId();
	      $nombreCiudad = $ciudadC->getNombre();
	      echo json_encode($nombreCiudad);
	}
	
	if(filter_has_var(INPUT_GET, "nombreCiudadB") && filter_has_var(INPUT_GET, "buscar")){
	     require_once("../clases/ClassMongoClient.php");
	     $ciudad = filter_input(INPUT_GET, "nombreCiudadB");
	     $mongo = new DBMongo("ciudad");
	     $regexObj = new MongoRegex("/".$ciudad."/"); 
	     $query = array("ciudad" => $regexObj);
	     $todasciudades = $mongo->findCollection($query);
	     #paises
	     $mongoPais = new DBMongo("pais");
	     $regexObjPais = new MongoRegex("/".$ciudad."/"); 
	     $queryForPais = array("pais" => $regexObjPais);
	     $todosPaises=$mongoPais->findCollection($queryForPais);
	     //var_dump($todasciudades);
	     /*for($i = 0;$i<count($todasciudades); $i++){
	            $queryForPais = array("_id"=>$todasciudades[$i]["idPais"]);
	            $todasciudades[$i][] = $mongo->findCollection($queryForPais);
	     }*/
	     echo json_encode(array_merge($todasciudades, $todosPaises));
	}
	


?>