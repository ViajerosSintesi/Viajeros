<?php

/**
 * controlador para el objeto de ciudad
 */


/**
 * si le llega nombreCiudad (id de la ciudad) 
 * devuelve en formato JSON el nombre de la ciudad con ese id
 * 
 */
if(filter_has_var(INPUT_GET, "nombreCiudad")){
	require_once("../clases/CiudadClass.php");
	$ciudadC = new Ciudad();
	$id = filter_input(INPUT_GET, "nombreCiudad");
	$ciudadC->setId($id);
	$ciudadC->cogeValoresSegunId();
	$nombreCiudad = $ciudadC->getNombre();
	echo json_encode($nombreCiudad);
}


/**
 * nombreCiudadB que le llega a este archivo como parametro es el nombre a buscar
 * en la BBDD de ciudades i paises
 *
 * buscar es un parametro bool solo para identificar la funcion
 *
 * devuelve en formato JSON los datos encontrados
 */
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
	    
    echo json_encode(array_merge($todasciudades, $todosPaises));
}

/**
 *
 * incluye la ciudad dentro de user->lugares
 *
 * incluirCiudadUser: ciudad a incluir
 * user: usuario a quien introducir la ciudad
 *
 * comprueba que en la variable de ssession exista el user i 
 * que sea el mismo que el pasado como parametro.
 * si no, no lo inserta
 *
 * devuelve si lo ha podido insertar en formato JSON
 */
if(filter_has_var(INPUT_GET,"incluirCiudadUser")){
	require_once("../clases/UserClass.php");
      require_once("../clases/CiudadClass.php");
	$ciudad = filter_input(INPUT_GET,"incluirCiudadUser");
	$userId = filter_input(INPUT_GET,"user");
      $ciudadId = filter_input(INPUT_GET,"ciudadId");
	session_start();
	if(isset($_SESSION["userId"])){
		if($_SESSION["userId"] == $userId){
		      $ciudadC = new Ciudad();
	            $ciudadC->setId($ciudadId);
	            $ciudadC->cogeValoresSegunId();
	            $coor = $ciudadC->getCoordenadas();
	            $param = array('coor'=>$coor, 'direc'=>$ciudad);
			$user = new User();
			$user->setId($userId);
			$user->setLugares($param);

			echo json_encode($user->incluirCiudad());
		}else echo json_encode(0);
	}else echo json_encode(0);

}


/**
 * saberciudadesUser: nombre de la ciudad
 * user: usuario
 *
 * saber si el usuario ha estado en la ciudad
 *
 * devuelve true si ha estado, false si no
 */
if(filter_has_var(INPUT_GET,"saberCiudadUser")){
	require_once("../clases/UserClass.php");
     
	$ciudad = filter_input(INPUT_GET,"saberCiudadUser");
	$userId = filter_input(INPUT_GET,"user");

	$user = new User();
	$user->setId($userId);
	$user->cogeValoresSegunId();
      $retorn= 0;
	$lugares = $user->getLugares();
      for($i=0;$i<count($lugares); $i++)
            if($retorn = in_array($ciudad, $lugares[$i]))
                  break;
      
	echo json_encode($retorn);
}


?>