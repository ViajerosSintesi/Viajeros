<?php


require_once("ClassMongoClient.php");
	/**
	* clase pregunta
	*/
	class Pregunta{
		
		private $id = null;				#id de la Pregunta
		private $user = null;			#usuario que a formulado la pregunta
		private $pregunta = null;		#texto de la pregunta
		private $idSitio = null;		#sitio donde se a formulado
		private $bbdd;					#BBDD de pregunta
		private $fecha = null;			#fecha de la pregunta
		
		/**
		 * [__construct description]
		 *
		 * al construirse se conecta a la coleccion que se le pasa por parametro
		 * esto se debe a que no estan ubicadas en el mismo sitio las preguntas
		 * de ciudad y pais
		 * 
		 * @param string $bbdd 			nombre de la coleccion a la que conectarse
		 */
		function __construct($bbdd){
            $this->bbdd = new DBMongo($bbdd);
        }
      	/**
      	 * getters and setters
      	 */
      	public function getId(){return $this->id;}
        public function setId($id){$this->id = $id;}
        public function getUser(){return $this->user;}
        public function setUser($user){$this->user = $user;}
        public function getPregunta(){return $this->pregunta;}
        public function setPregunta($pregunta){$this->pregunta = $pregunta;}
        public function getIdSitio(){return $this->idSitio;}
        public function setIdSitio($idSitio){$this->idSitio = $idSitio;}
        public function getFecha(){return $this->fecha;}
        public function setFecha($fecha){$this->fecha = $fecha;}
        

        /**
         * [cogeValoresSegunId description]
         *
         * funcion que busca por id la pregunta i guarda sus valores en las propiedades
         * @return [type] [description]
         */
        public function cogeValoresSegunId(){
        	$queryForId = array('_id' => $this->id);
        	if($this->bbdd->contar($queryForId)){
        		$coment = $this->bbdd->findOneCollection($queryForId);
        		$this->id = $coment['_id'];
        		$this->usuario = $coment['idUsu'];
        		$this->idSitio= (isset($coment['idCiu']))? $coment['idCiu'] : $coment['idPais'];
        		$this->fecha = $coment['data'];
        	}
        }
        /**
         * [borrarPregunta description]
         * borra la pregunta a partir de la id
         * 
         * @return bool 	 devulve si ha podido elimnarla o no
         */
        public function borrarPregunta(){
        	$queryForDelete = array("_id"=>new MongoId($this->id));
        	return  $this->bbdd->eliminar($queryForDelete);
        }
        /**
         * [devolverDelSitio description]
         *
         * funcion que devuelve las preguntas del sitio donde se han hecho 
         * 
         * @param  string $tipo 	      si es ciudad o pais
         * @return array[]	       	todas las preguntas encontradas
         */
        public function devolverDelSitio($tipo){
        	if($tipo == "Pais")
        		$query = array("idPais" =>new MongoId($this->idSitio));
        	elseif($tipo = "Ciudad")
        		$query = array('idCiu'=>new MongoId($this->idSitio));
         
			//$queryForView = array("_id"=>false, "valor"=>true);
        	return  $this->bbdd->findCollection($query);
        }
        /**
         * [insertarPregunta description]
         *
         * inserta la pregunta en su respectiva BBDD
         * se le ha de pasar como parametro si es en ciudad o pais ya que cambia la
         * clave de la propiedad
         * 
         * @param  string $tipo 	si es ciudad o pais
         * @return bool       		devuelve si lo ha conseguido insertar
         */
        public function insertarPregunta($tipo){
        	$queryForInsert = array("idUsu"=>$this->user, 
        		"pregunta"=>$this->pregunta,
        		"data"=>$this->fecha);
        	if($tipo == "Ciudad") $queryForInsert["idCiu"]= $this->idSitio;
        	elseif($tipo == "Pais") $queryForInsert["idPais"]= $this->idSitio;

        	return $this->bbdd->insertar($queryForInsert);
        }
    }

    ?>