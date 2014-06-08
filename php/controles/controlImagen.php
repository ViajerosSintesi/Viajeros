<?php
require_once("../clases/ImagenClass.php");
require_once("../clases/UserClass.php");
require_once("../clases/CiudadClass.php");
require_once("../clases/ClassMongoClient.php");
session_start();

/**
 * si se le pasa un archivo de imagen, este lo guarda
 *
 * userid: usuario que sube la imagen
 * ciudad id: "ciudad - pais"
 *
 * no devuelve nada, reenvia otra vez a la pagina
 * 
 */
 
if(isset($_FILES["picture"])){

	$userId= filter_input(INPUT_POST, "userId");
	$ciudadId= filter_input(INPUT_POST, "ciudadId");
	$ciudadId = explode(" ", $ciudadId);

	$ciudad = new Ciudad();
	if(isset($ciudadId[2])){
		$ciudad->setNombre($ciudadId[0]);
		$ciudad->setPais($ciudadId[2]);
		$ciudad->buscarCiudad("ciudad");
		$location="perfil.php";
	}else{
		$ciudad->setId($ciudadId[0]);
		$ciudad->cogeValoresSegunId();
		$location="ciudad.php?ciudad=$ciudadId[0]";
	}

	$imagenForUp = $_FILES["picture"];
	$imagen = new Imagen();

	$imagen->setNombre($imagenForUp["name"]);
	$imagen->setCiudad($ciudad->getNombre());
	$imagen->setPais($ciudad->getPais());
	$imagen->setUsuario($userId);
	$imagen->setRuta();

	$imagen->subirImagen($imagenForUp);
            //echo $userId;
            //echo $imagen->guardarImagen();
	header("location: ../../".$location);

}

/**
 * fotosFor perfil, es solo para pedir la funcion, con que exista, ya vale.
 * userId: id del user que tiene que buscar
 * devulve las rutas imagenes que ha subido el usuario en formato JSON
 *  
 */
if(filter_has_var(INPUT_GET, "fotosForPerfil")){
	$userId= filter_input(INPUT_GET, "userId");

	$imagen = new Imagen();

	$imagen->setUsuario($userId);

	echo json_encode($imagen->darImagenes());

}
/**
 * borrarImagen, es solo para pedir la funcion, con que exista ya vale
 * imagenId : id de la imagen
 *
 * borra la imagen, tanto del servidor como de la BBDD. Tambien remueve sus valoraciones
 * de la BBDD
 */
if(filter_has_var(INPUT_GET, "borrarImagen")){

	$imagenId = filter_input(INPUT_GET, "imagenId");

	$imagen = new Imagen();

	$imagen->setId(new MongoId($imagenId));

	$imagen->cogeValoresSegunId();

	$valorBbdd = new DBMongo("valoracionimg");

	$queryForRemove=array("object"=>$imagenId);

	$valorBbdd->eliminar($queryForRemove);

	echo json_encode($imagen->borrarImagen());
}

/**
 * fotosForCiudad es solo para pedir la funcion, con que exista ya vale
 * ciudadId : id de la ciudad para pedir las imagenes
 *
 * devulve las rutas de la ciudad seleccionada
 */
if(filter_has_var(INPUT_GET, "fotosForCiudad")){
	$ciudadId= filter_input(INPUT_GET, "ciudadId");
	$ciudad = new Ciudad();

	$ciudad->setId($ciudadId);
	$ciudad->cogeValoresSegunId();
	$imagen = new Imagen();

	$imagen->setCiudad($ciudad->getNombre());

	echo json_encode($imagen->darImagenes(false));

}

/**
 * pais: id del pais
 *
 * devuelve todas las rutas de imagenes que se han hecho en sus ciudades
 *
 * en formato JSON
 */
if(filter_has_var(INPUT_GET, "pais")){
	require_once("../clases/PaisClass.php");
	$paisId= filter_input(INPUT_GET, "pais");
	$pais = new Pais();
	$pais->setId($paisId);
	$ciudadesDelPais = $pais->listarCiudadesPais();
            //var_dump($ciudadesDelPais);
	for($i=0; $i<count($ciudadesDelPais);$i++){
		$imagen = new Imagen();
		$imagen->setCiudad($ciudadesDelPais[$i]["ciudad"]);

		echo json_encode($imagen->darImagenes(false));
	}
}

?>