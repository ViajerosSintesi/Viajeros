<?php
require_once("ClassMongoClient.php");
/**
 * 
 * clase encargada de controlar la imagen
 * 
 **/

class imagen {	  

	private $id = null;					#id de la imagen
	private $ruta = null;				#ruta donde se encuentra la imagen
	private $nombre = null;				#nombre de la imagen
	private $usuario = null;			#usuario que ha subido la imagen
	private $ciudad = null;				#ciudad de donde es la foto
	private $pais = null;				#pais de donde es la foto
    private $bbdd = null;				#bbdd de imagenes
    private $imageArray = null;		#array con las propiedades del objeto

    /**
     * constructor por defecto que se conecta a la coleccion imagenes
     */
	function __construct(){
	    $this->bbdd = new DBMongo("imagenes");
	}
	/**
	 * getters and setters
	 */
	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getNombre(){return $this->nombre;}
	public function setNombre($nombre){$this->nombre = $nombre;}
	public function getRuta(){return $this->ruta;}
	/**
	 * [setRuta description]
	 * set que contruye la ruta si no se le pasa por parametro
	 * 
	 * @param string $ruta 		ruta de la imagen 
	 */
	public function setRuta($ruta=""){
	      if ($ruta=="")$this->ruta ='../../images/fotosCiudades/'.$this->pais.'/'.$this->ciudad.'/'.$this->usuario.'/';
	      else $this->ruta = $ruta;
	     }
	public function getUsuario(){return $this->usuario;}
	public function setUsuario($usuario){$this->usuario = $usuario;}
	public function getCiudad(){return $this->ciudad;}
	public function setCiudad($ciudad){$this->ciudad = $ciudad;}
	public function getPais(){return $this->pais;}
	public function setPais($pais){$this->pais = $pais;}

	/**
	 * [subirImagen description]
	 *
	 * funcion que sube la imagen al servidor
	 * 
	 * @param  file $fileImg 	archivo imagen
	 * @return bool             retorna si la guarda en la BBDD y si la ha subido
	 */
	public function subirImagen($fileImg){
	  $retorn = 0;
	  $uploaddir = $this->ruta;
	   #si no existe la carpeta, la crea 
	    if (!file_exists($uploaddir)) 
	        mkdir($uploaddir, 0777, true);
	        
	    $uploadfile = $uploaddir.basename($fileImg['name']);
	    
	    if (move_uploaded_file($fileImg['tmp_name'], $uploadfile)) {
	        #borra la antigua imagen
	        $retorn = $this->guardarImagen();
	    }
	    return $retorn;

	}

	/**
	 * [guardarImagen description]
	 *
	 * guarda los datos de la imagen en la BBDD
	 * 
	 * @return Boolean 		Retona si lo ha conseguido guardar
	 */
	public function guardarImagen(){
	    $retorn = 0;
	    $this->imageToArray();
	    if($this->imageArray['_id'] == null) unset($this->imageArray['_id']);
	    if(!$this->bbdd->contar(array("_id"=>$this->id))){
	          $retorn = $this->bbdd->insertar($this->imageArray);
	    }
	    return $retorn;
	}

	/**
	 * [cogeValoresSegunId description]
	 * cogiendo de base solo el id de la imagen, busca en la BBDD y guarda 
     * la informacion en sus respectivas propiedades
	 */
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
	/**
	 * [imageToArray description]
	 * funcion que pasa las propiedades del objeto a formato array
	 * lo guarda en la propiedad imageToArray
	 * 
	 */
	public function imageToArray(){
	    $this->imageArray = array(
	                      "_id" => $this->id,
	                      "nombre" => $this->nombre,
	                      "ruta" => $this->ruta,
	                      "ciudad" => $this->ciudad,
	                      "usuario" => $this->usuario
	                );
	}

	/**
	 * [darImagenes description]
	 *
	 * retorna todas la imagenes dependiendo el parametro
	 * si $porUser = true delvuelve las imagenes del usuario
	 * si no, devuelve la imagenes de la ciudad
	 * 
	 * @param  boolean $porUser 	paramentro de devolucion si por usuario o por ciudad
	 * @return Array[]				devuelve las imagenes
	 */
	public function darImagenes($porUser=true){
	    $queryForImages = array();
	    if($porUser) $queryForImages = array('usuario' => $this->usuario);
	    else $queryForImages = array('ciudad' => $this->ciudad);
	    
	    return $this->bbdd->findCollection($queryForImages);
	}

	/**
	 * [borrarImagen description]
	 *
	 * borra las imagenes tanto de la BBDD como los archivos 
	 * 
	 * @return bool 	devuelve si ha conseguido borrarlo
	 */
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