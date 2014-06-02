<?php
require_once("clases/ClassMongoClient.php");
// conectar
global $collection, $m, $db;
function conectar($co="pais"){
	global $collection, $m, $db;
	
      $mongo = new DBMongo($co);
	// seleccionar una colección (equivalente a una tabla en una base de datos relacional)
	$collection = $mongo->selectCollection($co);
	return $collection;
}

// añadir un registro
/*$document = array( "pais" => "España", "info" => "España, también denominado Reino de España, es un país soberano, miembro de la Unión Europea, constituido en Estado social y democrático de derecho y cuya forma de gobierno es la monarquía democrática parlamentaria. Su territorio está organizado en 17 comunidades autónomas y dos ciudades autónomas. Su capital es la villa de Madrid.
Es un país transcontinental que se encuentra situado tanto en Europa Occidental como en el norte de África. En Europa ocupa la mayor parte de la península ibérica, conocida como España peninsular, y el archipiélago de las islas Baleares (en el mar Mediterráneo occidental); en África se hallan las ciudades de Ceuta (en la península Tingitana) y Melilla (en el cabo de Tres Forcas), las islas Canarias (en el océano Atlántico nororiental), las islas Chafarinas (mar Mediterráneo), el peñón de Vélez de la Gomera (mar Mediterráneo), las islas Alhucemas (golfo de las islas Alhucemas), y la isla de Alborán (mar de Alborán). El municipio de Llivia, en los Pirineos, constituye un enclave rodeado totalmente por territorio francés. Completa el conjunto de territorios una serie de islas e islotes frente a las propias costas peninsulares.
Tiene una extensión de 504 645 km², siendo el cuarto país más extenso del continente, tras Rusia, Ucrania y Francia. Con una altitud media de 650 metros es uno de los países más montañosos de Europa. Su población es de 47 190 493 habitantes, según datos del padrón municipal de 2011. El territorio peninsular comparte fronteras terrestres con Francia y con el principado de Andorra al norte, con Portugal al oeste y con el territorio británico de Gibraltar al sur. En sus territorios africanos, comparte fronteras terrestres y marítimas con Marruecos. Comparte con Francia la soberanía sobre la isla de los Faisanes en la desembocadura del río Bidasoa y cinco facerías pirenaicas.",
"coordenadas"=> "40.2085,-3.713,6" );
$collection->insert($document);*/

// encontrar todo lo que haya en la colección
//$cursor = $collection->find();

// recorrer el resultado
/*foreach ($cursor as $document) {
    echo $document["pais"] . "\n";
    echo $document["coordenadas"];
}*/
function listPaises(){
	$collection = conectar();
	$cursor = $collection->find()->sort(array('pais'=>1));
	return $cursor;
}
function obtenerInfoPais($pais){
	$collection = conectar();
	$parametro = array('_id'=>new MongoId($pais));
	$cursor = $collection->findOne($parametro);
	return $cursor;
}
function obtenerInfoCiudad($ciudad){
	$collection = conectar("ciudad");
	$parametro = array('_id'=>new MongoId($ciudad));
	$cursor = $collection->findOne($parametro);
	return $cursor;
}
function obtenerCoordenadasPais($pais){
	$collection = conectar();
	$parametro = array('_id'=>new MongoId($pais));
	$cursor = $collection->findOne($parametro);
	return $cursor["coordenadas"];
}
function obtenerCoordenadasCiudad($ciudad){
	$collection = conectar("ciudad");
	$parametro = array('_id'=>new MongoId($ciudad));
	$cursor = $collection->findOne($parametro);
	return $cursor["coordenadas"];
}
function modificarInfoPais($pais, $info){
	$collection = conectar();
	$infor = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $info);
	$parametro = array('_id'=>new MongoId($pais));
	$variable = array('$set'=>array('info'=> utf8_encode($infor)));
	$collection->update($parametro, $variable);

}
function modificarInfoCiudad($info, $ciudad){
	$collection = conectar("ciudad");
	$infor = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $info);
	$variable = array('$set'=>array('info'=> utf8_encode($infor)));
	$collection->update(array('_id'=>new MongoId($ciudad)), $variable);

}
function cargarComentPais($pais){
	$collection = conectar("comentPais");
	$parametro = array('idPais'=>new MongoId($pais));
	$cursor = $collection->find($parametro);
	return $cursor;
}
function cargarComentCiudad($ciudad){
	$collection = conectar("comentCiudad");
	$parametro = array('idCiu'=>new MongoId($ciudad));
	$cursor =$collection->find($parametro);
	return $cursor;
}
function datosUnUsuario($valor){
	$collection = conectar("usuarios");
	$parametro = array("_id"=>$valor);
	$cursor = $collection->findOne($parametro);
	return $cursor;
}
function paisCiudades($id){
	$collection = conectar("ciudad");
	$parametro = array("idPais"=>$id);
	$cursor = $collection->find($parametro)->sort(array('ciudad'=>1));
	return $cursor;
}
function lugaresUsuario($usu){
	$collection = conectar("usuarios");
	$par = array("_id"=>$usu);
	$parametro = array("_id"=>0,"lugares"=>1);
	$cursor = $collection->findOne($par,$parametro);
	return $cursor;
}
?>