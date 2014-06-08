<?php

require_once("../clases/ValoracionClass.php");
require_once("../clases/PreguntaClass.php");
require_once("../clases/UserClass.php");
  /**
 * ciudad: nombre de la ciudad/pais
 * verPreguntas: tipo si es ciudad o pais
 * user: usuario
 *
 * se le pasa el nombre de la ciudad/pais, el tipo  y el usuario. 
 * devuelve un array con toda la informacion de los PReguntas del sitio
 *
 * devuelve la valoracion del Pregunta en formato JSON
 */
  if(filter_has_var(INPUT_GET, "ciudad") && filter_has_var(INPUT_GET, "verPreguntas")){
  	$ciudad = filter_input(INPUT_GET, "ciudad");
  	$userId = filter_input(INPUT_GET, "userId");
  	$tipo = filter_input(INPUT_GET, "verPreguntas");
  	$preguntaCiudad = new Pregunta("pregunta".$tipo);

  	$preguntaCiudad->setIdSitio($ciudad);
  	$preguntas = $preguntaCiudad->devolverDelSitio($tipo);

  	$valoracionPregunta = new Valoracion("valoracionpregunta");
  	$valoracionPregunta->setUser($userId);
  	$user = new User();
  	for($i=0;$i<count($preguntas);$i++){
  		$valoracionPregunta->setObject($preguntas[$i]["_id"]->{'$id'});
  		$valoraciones = $valoracionPregunta->verValoraciones();
  		$preguntas[$i]["valorNeg"]=0;
  		$preguntas[$i]["valorPos"]=0;

  		for($x = 0; $x<count($valoraciones); $x++){
  			if($valoraciones[$x]["valor"] == 1) $preguntas[$i]["valorNeg"]++;
  			elseif($valoraciones[$x]["valor"] == 2)$preguntas[$i]["valorPos"]++; 
  		}
  		$preguntas[$i]["valorDelUser"] = $valoracionPregunta->verValoracionDelUsuario(); 
  		$user->setId($preguntas[$i]["idUsu"]);
  		$user->cogeValoresSegunId();
  		$preguntas[$i]["nombreDelUser"] = $user->getUsername();
  		$preguntas[$i]["imgPerfilUser"] = $user->getImgPerfil();
  	}

  //echo "<pre>";
  //var_dump($preguntas);

  	echo json_encode($preguntas);

  }
/**
 * ciudad: nombre de la ciudad donde se interta
 * insertarPregunta: el tipo,si es ciudad o pais
 * userId: el usuario que lo inserta
 * comentText_ texto del Pregunta
 * data: la fecha
 *
 * encargado de insertar el Pregunta en la BBDD
 *
 * comprueba que exista en SESSION el usuario->y que sea el mismo que entra como parametro
 *
 * crea una cookie con un contador de pregunta por tiempo, para que solo permita un Pregunta al minuto
 *
 *
 * devuelve si ha podido insertar true or false
 * 
 */
if(filter_has_var(INPUT_GET,"ciudad")&& filter_has_var(INPUT_GET, "insertarPregunta")){
	$ciudad = filter_input(INPUT_GET, "ciudad");
	$userId = filter_input(INPUT_GET, "userId");
	$tipo = filter_input(INPUT_GET, "insertarPregunta");
	$preguntaText = filter_input(INPUT_GET, "pregunta");
	$data = filter_input(INPUT_GET, "fecha");
	$pregunta= new Pregunta("pregunta".$tipo);

	$pregunta->setUser($userId);
	$pregunta->setIdSitio(new MongoId($ciudad));
	$pregunta->setPregunta($preguntaText);
	$pregunta->setFecha($data);
	$inserta = 0;
	session_start();
	if(isset($_SESSION["userId"])){
		if($_SESSION["userId"] == $userId){
			if(filter_has_var(INPUT_COOKIE,"pregunta")){
				$numIntentos = filter_input(INPUT_COOKIE,"pregunta");

				if($numIntentos <4){
					$expire=time()+60*4;
					$inserta =1;
					setcookie("pregunta", $numIntentos+1, $expire);
				}
			}else{
				$expire=time()+60*4;
				setcookie("pregunta", 0, $expire);
			}
		}
	}
	if($inserta){
		echo json_encode($pregunta->insertarPregunta($tipo));
	} else{
		echo json_encode(0);
	}

}

?>