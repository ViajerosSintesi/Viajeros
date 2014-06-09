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
/**
* funcion para insertar en mongodb un nuevo pais
* @return no retorna nada.
* @param $pais, $info, $coordenadas, contienen los datos necesarios para realizar la insercion.
*/
function insertarPais($pais, $info, $coordenadas){
	$collection = conectar();
	$parametros = array('pais'=>$pais, 'info'=>$info, 'coordenadas'=>$coordenadas);
	$cursor = $collection->insert($parametros);
}
/**
* funcion para insertar en mongodb una nueva ciudad.
* @return no retorna nada.
* @param $ciudad, $info, $coordenadas,$pertenece, contiene los datos para la insercion en la coleccion de ciudad.
*/
function insertarCiudad($ciudad, $info, $coordenadas, $pertenece){
	$collection = conectar("ciudad");
	$parametros = array('ciudad'=>$ciudad, 'info'=>$info, 'coordenadas'=>$coordenadas, 'idPais'=>new MongoId($pertenece));
	$cursor = $collection->insert($parametros);
}
/** 
* funcion que conecta a mongo y devuelve la informacion de la colleccion pais
* @return devuelve un array con la informacion de la colleccion.
* @param no parametros.
*/
function listPaises(){
	$collection = conectar();
	$cursor = $collection->find()->sort(array('pais'=>1));
	return $cursor;
}
/** 
* funcion que conecta a mongo y devuelve una unica fila de informacion de la colleccion pais
* @return devuelve un array con la informacion.
* @param $pais que contiene el identificador.
*/
function obtenerInfoPais($pais){
	$collection = conectar();
	$parametro = array('_id'=>new MongoId($pais));
	$cursor = $collection->findOne($parametro);
	return $cursor;
}
/** 
* funcion que conecta a mongo y devuelve una unica fila de informacion de la colleccion ciudad
* @return devuelve un array con la informacion de la colleccion.
* @param $ciudad que contiene el identificador.
*/
function obtenerInfoCiudad($ciudad){
	$collection = conectar("ciudad");
	$parametro = array('_id'=>new MongoId($ciudad));
	$cursor = $collection->findOne($parametro);
	return $cursor;
}
/** 
* funcion que conecta a mongo y devuelve una unica fila de informacion de la colleccion pais
* @return devuelve el valor del campo coordenadas.
* @param $pais que contiene el identificador.
*/
function obtenerCoordenadasPais($pais){
	$collection = conectar();
	$parametro = array('_id'=>new MongoId($pais));
	$cursor = $collection->findOne($parametro);
	return $cursor["coordenadas"];
}
/** 
* funcion que conecta a mongo y devuelve una unica fila de informacion de la colleccion ciudad
* @return devuelve el valor del campo coordenadas.
* @param $ciudad que contiene el identificador.
*/
function obtenerCoordenadasCiudad($ciudad){
	$collection = conectar("ciudad");
	$parametro = array('_id'=>new MongoId($ciudad));
	$cursor = $collection->findOne($parametro);
	return $cursor["coordenadas"];
}
/** 
* funcion que conecta a mongo y realiza una modificacion a un documento.
* @return no devuelve nada.
* @param $pais, $info, que contiene el identificador y la informacion.
*/
function modificarInfoPais($pais, $info){
	$collection = conectar();
	$infor = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $info);
	$parametro = array('_id'=>new MongoId($pais));
	$variable = array('$set'=>array('info'=> utf8_encode($infor)));
	$collection->update($parametro, $variable);

}
/** 
* funcion que conecta a mongo y realiza una modificacion a un documento.
* @return no devuelve nada.
* @param $ciudad, $info, que contiene el identificador y la informacion.
*/
function modificarInfoCiudad($info, $ciudad){
	$collection = conectar("ciudad");
	$infor = iconv("UTF-8", "ISO-8859-1//TRANSLIT", $info);
	$variable = array('$set'=>array('info'=> utf8_encode($infor)));
	$collection->update(array('_id'=>new MongoId($ciudad)), $variable);

}
/*function cargarComentPais($pais){
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
}*/
/** 
* funcion que conecta a mongo devuelve un documento con informacion de una usuario.
* @return devuelve un documento.
* @param $valor.
*/
function datosUnUsuario($valor){
	$collection = conectar("usuarios");
	$parametro = array("_id"=>$valor);
	$cursor = $collection->findOne($parametro);
	return $cursor;
}
/** 
* funcion que conecta a mongo y realiza un consulta de todas las ciudades que pertenecen a un pais.
* @return $cursor, que devuelve toda la información en arrays.
* @param $id, que contiene el identificador.
*/
function paisCiudades($id){
	$collection = conectar("ciudad");
	$parametro = array("idPais"=>$id);
	$cursor = $collection->find($parametro)->sort(array('ciudad'=>1));
	return $cursor;
}
/** 
* funcion que conecta a mongo y realiza una consulta a la collecion usuarios
* sobre un campo especifico que es lugares.
* @return $cursor, que contiene las coordenadas de un usuario.
* @param $usu que contiene el identificador y la informacion.
*/
function lugaresUsuario($usu){
	$collection = conectar("usuarios");
	$par = array("_id"=>$usu);
	$parametro = array("_id"=>0,"lugares"=>1);
	$cursor = $collection->findOne($par,$parametro);
	return $cursor;
}
/** 
* funcion que conecta a mongo y realiza una insercion en la colleccion usuarios.
* @return no devuelve nada.
* @param $usu, $coor, $infolugar que contiene el identificador, las coordenadas y la informacion.
*/
function guardarUbicacion($usu, $coor, $infoLugar){
	$collection = conectar("usuarios");
	$parametro = array("_id"=>$usu);
	$param = array('$push'=>array('lugares'=> array('coor'=>$coor, 'direc'=>$infoLugar)));
	$cursor = $collection->update($parametro, $param);;
}
?>