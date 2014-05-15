<?php
require_once("ClassMongoClient.php");
/**
 * 
 * en la tabla imagenes tiene el formato:
 * 
 * {
 *   "_id": id,
 *   "ruta": ruta a la imagen,
 *   "cod_ciudad": codigo en la ciudad que ha sido hecha
 *   "cod_usuario": id del usuario que ha tomado la foto
 * }
 * 
 **/

/**
* 
*/
class imagen {	  

	private $id = null;
	private $ruta = null;
	private $usuario = null;
	private $ciudad = null;
		  
	function __construct(){
	    $this->bbdd = new DBMongo("imagenes");
	}
	
	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getRuta(){return $this->ruta;}
	public function setRuta($ruta){$this->ruta = $ruta;}
	public function getUsuario(){return $this->usuario;}
	public function setUsuario($usuario){$this->usuario = $usuario;}
	public function getCiudad(){return $this->ciudad;}
	public function setCiudad($ciudad){$this->ciudad = $ciudad;}

}
?>