<?php
require_once("ClassMongoClient.php");

	/**
	* clase valoracion
	*/
	class Valoracion{
		private $user = null;	 	#usuario que valora
		private $object = null;		#objeto a valorar
		private $valor = null;		#nota que se le da
		private $bbdd;			#conexion a la coleccion
		private $arrayValor;		#formato array de la clase

		/**
		 * [__construct description]
		 * dado el nombre de la coleccion se conecta
		 * @param string $bbdd 	nombre de la coleccion a la que conectarse
		 */
		function __construct($bbdd){
			$this->bbdd = new DBMongo($bbdd);
		}
		/**
		 * getters an setters
		 */
		public function getUser() {return $this->user;}
		public function setUser($user) {$this->user = $user;}
		public function getObject() {return $this->object;}
		public function setObject($object) {$this->object = $object;}
		public function getValor() {return $this->valor;}
		public function setValor($valor) {$this->valor = $valor;}

		/**
		 * [valoracionToArray description]
		 * 
		 * transforma las propiedades a formato array
		 */
		public function valoracionToArray(){
			$this->arrayValor = array(
				"user"=> $this->user,
				"object"=> $this->object,
				"valor"=>$this->valor
				);
		}
		/**
		 * [verValoraciones description]
		 * devuelve las valoraciones que tiene un objeto
		 * 
		 * @return array[]  	notas que encuentra
		 */
		public function verValoraciones(){
			$query = array("object"=>$this->object);
			$queryForView = array("_id"=>false, "valor"=>true);
			return $this->bbdd->findCollection($query,$queryForView);
		}
		/**
		 * [insertValoracion description]
		 *
		 * inserta una nueva valoracion al objeto
		 * segun el parametro, comprueva si existe o no existe en la BBDD
		 *
		 * si param == true, insertara la nueva valoracion si no existe ya
		 * si param == false, sobrescribe la antigua valoracion
		 * 
		 * @param  boolean $compr  		opcion de comprovar  si existe o no
		 * @return boolean 				respuesta de si consigue o no insrtarla
		 */
		public function insertValoracion($compr=true){
			$retorn = 0;
			$this->valoracionToArray();
			if($compr){
				if(!$this->comproveValoracion())
					$retorn = $this->bbdd->insertar($this->arrayValor);
			}else{
				$queryForSearch = array("user"=> $this->user, 
					"object"=>$this->object);
				$this->bbdd->eliminar($queryForSearch);
				$retorn = $this->bbdd->insertar($this->arrayValor);
			}
			return $retorn;
		}
		/**
		 * [comproveValoracion description]
		 *
		 * coprueba si el usuario ha valorado a el objeto
		 * 
		 * @return int 		numero de veces que el usuario lo ha valorado
		 */
		public function comproveValoracion(){
			$queryForSearch = array("user"=> $this->user, 
				"object"=>$this->object);
			return $this->bbdd->contar($queryForSearch);
		}

		/**
		 * [verValoracionDelUsuario description]
		 *
		 * segun el usuario i el objeto, busca la valoracion que le ha dado
		 * 
		 * @return Array 		valor que el usuario le da al objeto
		 */
		public function verValoracionDelUsuario(){
			$query = array("user"=> $this->user, 
				"object"=>$this->object);
			$queryForView = array("_id"=>false, "valor"=>true);
			return $this->bbdd->findOneCollection($query,$queryForView);
		}
	}
	?>
