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
	private $nombre = null;
	private $usuario = null;
	private $ciudad = null;
      private $bbdd = null;
      private $imageArray = null;
	function __construct(){
	    $this->bbdd = new DBMongo("imagenes");
	}
	
	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getNombre(){return $this->nombrenombre
	public function setNombre($nombre){$this->nombre = $nombre;}
	public function getRuta(){return $this->ruta;}
	public function setRuta($ruta){$this->ruta = $ruta;}
	public function getUsuario(){return $this->usuario;}
	public function setUsuario($usuario){$this->usuario = $usuario;}
	public function getCiudad(){return $this->ciudad;}
	public function setCiudad($ciudad){$this->ciudad = $ciudad;}


      public function subirImagen(){
            
      }
      public function guardarImagen(){
            
      }
      public function cogeValoresSegunId(){
		$queryForId = array('_id' => $this->id);
		if($this->bbdd->contar($queryForId)){
			$imagen = $this->bbdd->findOneCollection($queryForId);
			$this->id = $imagen['_id'];
			$this->nombre = $imagen['nombre'];
			$this->usuario = $imagen['usuario'];
			$this->ciudad = $imagen['ciudad'];
			$this->ruta = $imagen['ruta'];
		}
	}
	
      public function imageToArray(){
            $this->imageArray = array(
                              "_id" => $this->id,
                              "nombre" => $this->nombre,
                              "ruta" => $this->ruta,
                              "ciudad" => $this->ciudad,
                              "usuario" => $this->usuario
                        );
      }
}
?>