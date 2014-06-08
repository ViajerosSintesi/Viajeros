<?php


require_once("ClassMongoClient.php");
/**
* clase respuesta
*/
class Respuesta{
	
	private $id = null;				#id de la respuesta
	private $user = null;			#usuario que ha respondido
	private $idPregunta = null;		#pregunta a la que pertenece
	private $respuesta = null;		#texto de la respuesta
	private $idSitio = null;		#sitio de la respuesta
	private $bbdd;					#coleccion de la BBDD
	private $fecha = null;			#fecha que se ha resondido
	
	/**
	 * [__construct description]
	 *
	 * constructor por defecto que dado el nombre d ela coleccion,
	 * se conecta a la misma
	 * 
	 * @param String $bbdd 		nombre de la colecciona a la que conectarse
	 */
	function __construct($bbdd){
		$this->bbdd = new DBMongo($bbdd);
	}
	/**
	 *
	 * getters and setters
	 * 
	 */
	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getUser(){return $this->user;}
	public function setUser($user){$this->user = $user;}
	public function getIdPregunta(){return $this->idPregunta;}
	public function setIdPregunta($idPregunta){$this->idPregunta = $idPregunta;}
	public function getRespuesta(){return $this->respuesta;}
	public function setRespuesta($respuesta){$this->respuesta = $respuesta;}
	public function getIdSitio(){return $this->idSitio;}
	public function setIdSitio($idSitio){$this->idSitio = $idSitio;}
	public function getFecha(){return $this->fecha;}
	public function setFecha($fecha){$this->fecha = $fecha;}

	/**
	 * [cogeValoresSegunId description]
	 * 
	 * funcion que busca por id la pregunta i guarda sus valores en las propiedades
	 */
	public function cogeValoresSegunId(){
		$queryForId = array('_id' => $this->id);
		if($this->bbdd->contar($queryForId)){
			$respuesta = $this->bbdd->findOneCollection($queryForId);
			$this->id = $respuesta['_id'];
			$this->usuario = $respuesta['idUsu'];
			$this->idSitio= (isset($respuesta['idCiu']))? $respuesta['idCiu'] : $respuesta['idPais'];
			$this->idPregunta= $respuesta['idPregunta'];
			$this->fecha = $respuesta['data'];
			$this->respuesta = $respuesta['respuesta'];
		}
	}
	/**
     * [borrarRespuesta description]
     * borra la Respuesta a partir de la id
     * 
     * @return bool 	 devulve si ha podido eliminarla o no
     */
	public function borrarRespuesta(){
		$queryForDelete = array("_id"=>new MongoId($this->id));
		return  $this->bbdd->eliminar($queryForDelete);
	}
	/**
	 * [devolverDeLaPregunta description]
	 *
	 * devuelve todas las respuestas que se han respondido
	 * @param  string $tipo 	si es de una ciudad o un pais
	 * @return array[]	       	todas las repsuestas encontradas
	 */	
	public function devolverDeLaPregunta($tipo){
		if($tipo == "Pais")
			$query = array("idPais" =>new MongoId($this->idSitio));
		elseif($tipo = "Ciudad")
			$query = array('idCiu'=>new MongoId($this->idSitio));
		$queryForInsert["idPregunta"] = $this->idPregunta;
            //var_dump($this->bbdd->findCollection($query));
            //$queryForView = array("_id"=>false, "valor"=>true);
		return  $this->bbdd->findCollection($query);
	}

	 /**
     * [insertarRespuesta description]
     *
     * inserta la respuesta en su respectiva BBDD
     * se le ha de pasar como parametro si es en ciudad o pais ya que cambia la
     * clave de la propiedad
     * 
     * @param  string $tipo 	si es ciudad o pais
     * @return bool       		devuelve si lo ha conseguido insertar
     */
	public function insertarRespuesta($tipo){
		$queryForInsert = array("idUsu"=>$this->user,
			"respuesta"=>$this->respuesta,
			"data"=> $this->fecha);
		if($tipo == "Ciudad") $queryForInsert["idCiu"]= $this->idSitio;
		elseif($tipo == "Pais") $queryForInsert["idPais"]= $this->idSitio;

		$queryForInsert["idPregunta"] = $this->idPregunta;
		return $this->bbdd->insertar($queryForInsert);
	}
}

?>