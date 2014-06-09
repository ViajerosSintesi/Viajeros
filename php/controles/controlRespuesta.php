<?php

require_once("../clases/ValoracionClass.php");
require_once("../clases/RespuestaClass.php");
require_once("../clases/UserClass.php");
    /**
 * ciudad: nombre de la ciudad/pais
 * verPreguntas: tipo si es ciudad o pais
 * user: usuario
 *
 * se le pasa el nombre de la ciudad/pais, el tipo  y el usuario. 
 * devuelve un array con toda la informacion de los respuesta del sitio
 *
 * devuelve la valoracion del respuesta en formato JSON
 */
    if(filter_has_var(INPUT_GET, "pregunta") && filter_has_var(INPUT_GET, "verRespuestas")){
    	$pregunta = filter_input(INPUT_GET, "pregunta", FILTER_SANITIZE_STRING);
    	$userId = filter_input(INPUT_GET, "userId", FILTER_SANITIZE_EMAIL);
    	$tipo = filter_input(INPUT_GET, "verRespuestas", FILTER_SANITIZE_STRING);
    	$respuestaCiudad = new Respuesta("respuesta".$tipo);
    	
    	$respuestaCiudad->setIdSitio($pregunta);
    	$respuestas = $respuestaCiudad->devolverDeLaPregunta($tipo);
    	
    	$valoracionRespuesta = new Valoracion("valoracionrespuesta");
    	$valoracionRespuesta->setUser($userId);
    	$user = new User();
    	for($i=0;$i<count($respuestas);$i++){
    		$valoracionRespuesta->setObject($respuestas[$i]["_id"]->{'$id'});
    		$valoraciones = $valoracionRespuesta->verValoraciones();
    		$respuestas[$i]["valorNeg"]=0;
    		$respuestas[$i]["valorPos"]=0;
    		
    		for($x = 0; $x<count($valoraciones); $x++){
    			if($valoraciones[$x]["valor"] == 1) $respuestas[$i]["valorNeg"]++;
    			elseif($valoraciones[$x]["valor"] == 2)$respuestas[$i]["valorPos"]++; 
    		}
    		$respuestas[$i]["valorDelUser"] = $valoracionRespuesta->verValoracionDelUsuario(); 
    		$user->setId($respuestas[$i]["idUsu"]);
    		$user->cogeValoresSegunId();
    		$respuestas[$i]["nombreDelUser"] = $user->getUsername();
    		$respuestas[$i]["imgPerfilUser"] = $user->getImgPerfil();
    	}
    	
  //echo "<pre>";
  //var_dump($respuestas);
    	
    	echo json_encode($respuestas);
    	
    }
/**
 * ciudad: nombre de la ciudad donde se interta
 * insertarRespuesta: el tipo,si es ciudad o pais
 * userId: el usuario que lo inserta
 * comentText_ texto de la respuesta
 * data: la fecha
 *
 * encargado de insertar el respuesta en la BBDD
 *
 * comprueba que exista en SESSION el usuario->y que sea el mismo que entra como parametro
 *
 * crea una cookie con un contador de respuesta por tiempo, para que solo permita un respuesta al minuto
 *
 * devuelve si ha podido insertar true or false
 */
if(filter_has_var(INPUT_GET,"pregunta")&& filter_has_var(INPUT_GET, "insertarRespuesta")){
	$pregunta = filter_input(INPUT_GET, "pregunta", FILTER_SANITIZE_STRING);
	$userId = filter_input(INPUT_GET, "userId", FILTER_SANITIZE_EMAIL);
	$tipo = filter_input(INPUT_GET, "insertarRespuesta", FILTER_SANITIZE_STRING);
	$respuestaText = filter_input(INPUT_GET, "respuesta", FILTER_SANITIZE_STRING);
	$data = filter_input(INPUT_GET, "fecha");
	$respuesta= new Respuesta("respuesta".$tipo);
	
	$respuesta->setUser($userId);
	$respuesta->setIdSitio(new MongoId($pregunta));
	$respuesta->setRespuesta($respuestaText);
	$respuesta->setFecha($data);
	$inserta = 0;
	session_start();
	if(isset($_SESSION["userId"])){
		if($_SESSION["userId"] == $userId){
			if(filter_has_var(INPUT_COOKIE,"respuesta")){
				$numIntentos = filter_input(INPUT_COOKIE,"respuesta");
				
				if($numIntentos <4){
					$expire=time()+60*4;
					$inserta =1;
					setcookie("respuesta", $numIntentos+1, $expire);
				}
			}else{
				$expire=time()+60*4;
				setcookie("respuesta", 0, $expire);
				$inserta = 1;
			}
		}
	}
	if($inserta){
		echo json_encode($respuesta->insertarRespuesta($tipo));
	} else{
		echo json_encode(0);
	}
}

?>