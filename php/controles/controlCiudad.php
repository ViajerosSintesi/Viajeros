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
	     $regexObj = new MongoRegex("/".$ciudad."/i"); 
	     $query = array("ciudad" => $regexObj);
	     $todasciudades = $mongo->findCollection($query);
	     #paises
	     $mongoPais = new DBMongo("pais");
	     $regexObjPais = new MongoRegex("/".$ciudad."/i"); 
	     $queryForPais = array("pais" => $regexObjPais);
	     $todosPaises=$mongoPais->findCollection($queryForPais);
	     //var_dump($todasciudades);
	     /*for($i = 0;$i<count($todasciudades); $i++){
	            $queryForPais = array("_id"=>$todasciudades[$i]["idPais"]);
	            $todasciudades[$i][] = $mongo->findCollection($queryForPais);
	     }*/
	     

	     echo json_encode(array_merge($todasciudades, $todosPaises));
	}
	
      if(filter_has_var(INPUT_GET,"incluirCiudadUser")){
            require_once("../clases/UserClass.php");
            
            $ciudad = filter_input(INPUT_GET,"incluirCiudadUser");
            $userId = filter_input(INPUT_GET,"user");
            session_start();
            if(isset($_SESSION["userId"])){
                  if($_SESSION["userId"] == $userId){
                        $user = new User();
                        $user->setId($userId);
                        $user->setLugares($ciudad);
                  
                        echo json_encode($user->incluirCiudad());
                  }else echo json_encode(0);
            }else echo json_encode(0);
            
      }
      
      if(filter_has_var(INPUT_GET,"saberCiudadUser")){
            require_once("../clases/UserClass.php");
            
            $ciudad = filter_input(INPUT_GET,"saberCiudadUser");
            $userId = filter_input(INPUT_GET,"user");
            $user = new User();
            $user->setId($userId);
            $user->cogeValoresSegunId();
             
            $lugares = $user->getLugares();
            
            echo json_encode(in_array($ciudad, $lugares));
      }
      

?>