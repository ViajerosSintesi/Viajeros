<?php

 require_once("ClassMongoClient.php");
	/**
	* Clase comentario
	*
	* encargada de administrar los comentarios
	*
	*/
	class Comment{
		
		private $id = null;				#id del comentario
		private $user = null;			#usuario que ha escrito el comentario
		private $comentario = null;		#texto del coment
		private $idSitio = null;		#sitio donde ha sido escrito
		private $bbdd;					#coleccion que hace referencia a mongo (class DBMongo)
		private $fecha = null;			#fecha en la que se escribio
		

		/**
		 * [__construct description]
		 *
		 * constructor por defecto, 
		 * dado un nombre de coleccion, se conecta a mongo y guarda la conexion en $this->bbdd
		 * 
		 * 
		 * @param String $bbdd nombre de la colleccion que aloja los comentrios
		 */
		function __construct($bbdd){
		      $this->bbdd = new DBMongo($bbdd);
		}
      	

		/**
		 * getters And Setters
		 */
  		public function getId(){return $this->id;}
        public function setId($id){$this->id = $id;}
        public function getUser(){return $this->user;}
        public function setUser($user){$this->user = $user;}
        public function getComentario(){return $this->comentario;}
        public function setComentario($comentario){$this->comentario = $comentario;}
        public function getIdSitio(){return $this->idSitio;}
        public function setIdSitio($idSitio){$this->idSitio = $idSitio;}
        public function getFecha(){return $this->fecha;}
        public function setFecha($fecha){$this->fecha = $fecha;}
        
        /**
	     * [cogeValoresSegunId description]
	     *
	     * cogiendo de base solo el id del comentario, busca en la BBDD y guarda 
	     * la informacion en sus respectivas propiedades
	     *
	     * primero comprueva si existe, si no existe, ni lo intenta
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
         * [borrarComent description]
         *
         * borra el comentario con la misma id
         * 
         * @return bool 	devulve si ha conseguido eliminarlo
         */
        public function borrarComent(){
              $queryForDelete = array("_id"=>new MongoId($this->id));
              return  $this->bbdd->eliminar($queryForDelete);
        }
        /**
         * [devolverDelSitio description]
         *
         * devuelve los comentarios del sitio que ha sido solicitado por el $this->sitio
         * si es de ciudad o pais se controla por el parametro $tipo
         * 
         * @param  string $tipo 	dependiendo si es ciudad o pais
         * @return array[]       	retorna array multidimensional con los resultados
         */
        public function devolverDelSitio($tipo){
              if($tipo == "Pais")
                    $query = array("idPais" =>new MongoId($this->idSitio));
              elseif($tipo = "Ciudad")
                    $query = array('idCiu'=>new MongoId($this->idSitio));
              //var_dump($this->bbdd->findCollection($query));
              //$queryForView = array("_id"=>false, "valor"=>true);
              return  $this->bbdd->findCollection($query);
        }

        /**
         * [insertarComent description]
         *
         * inserta un comentario en la coleccion
         *
         * depende de si es ciudad o pais
         * 
         * @param  string $tipo 	dependiendo si es ciudad o pais
         * @return bool 			retorna si ha podido insertarlo
         */
        public function insertarComent($tipo){
              $queryForInsert = array("idUsu"=>$this->user, 
                                      "comentario"=>$this->comentario,
                                      "data"=> $this->fecha);
              if($tipo == "Ciudad") $queryForInsert["idCiu"]= $this->idSitio;
              elseif($tipo == "Pais") $queryForInsert["idPais"]= $this->idSitio;
              
              return $this->bbdd->insertar($queryForInsert);
        }
	}
?>