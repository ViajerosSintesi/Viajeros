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
	private $pais = null;
      private $bbdd = null;
      private $imageArray = null;
	function __construct(){
	    $this->bbdd = new DBMongo("imagenes");
	}
	
	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getNombre(){return $this->nombre;}
	public function setNombre($nombre){$this->nombre = $nombre;}
	public function getRuta(){return $this->ruta;}
	public function setRuta($ruta=""){
	      if ($ruta=="")$this->ruta ='../images/fotosCiudades/'.$this->pais.'/'.$this->ciudad.'/'.$this->usuario.'/';
	      else $this->ruta = $ruta;
	     }
	public function getUsuario(){return $this->usuario;}
	public function setUsuario($usuario){$this->usuario = $usuario;}
	public function getCiudad(){return $this->ciudad;}
	public function setCiudad($ciudad){$this->ciudad = $ciudad;}
	public function getPais(){return $this->pais;}
	public function setPais($pais){$this->pais = $pais;}

      public function subirImagen($fileImg){
	      $retorn = 0;
	      $uploaddir = $this->ruta;
            
            if (!file_exists($uploaddir)) 
                mkdir($uploaddir, 0777, true);
                
            $uploadfile = $uploaddir.basename($fileImg['name']);
            
            if (move_uploaded_file($fileImg['tmp_name'], $uploadfile)) {
                #borra la antigua imagen
                $retorn = $this->guardarImagen();
            }
            return $retorn;
	
      }
      public function guardarImagen(){
            $retorn = 0;
            $this->imageToArray();
            if($this->imageArray['_id'] == null) unset($this->imageArray['_id']);
            if(!$this->bbdd->contar(array("_id"=>$this->id))){
                  $retorn = $this->bbdd->insertar($this->imageArray);
            }
            return $retorn;
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
      
      
      public function darImagenes($porUser=true){
            $queryForImages = array();
            if($porUser) $queryForImages = array('usuario' => $this->usuario);
            else $queryForImages = array('ciudad' => $this->ciudad);
            
            return $this->bbdd->findCollection($queryForImages);
      }
      
      public function borrarImagen(){
            $retorn = 0;
            $queryForId = array('_id' => $this->id);
            if($this->bbdd->contar($queryForId)){
                  if($this->bbdd->eliminar($queryForId)){
                        $pathToImage = $this->ruta.$this->nombre;
                        $retorn = unlink($pathToImage);
                  }
            }
            return $retorn;
      }
}
?>