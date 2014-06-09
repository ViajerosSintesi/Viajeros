<?php

/**
* class DBMongo
* 
* Clase encargada de controlar el acceso a los datos->BBDD
*
*	-> podriamos utilizar la clase Mongoclient directamente pero no podriamos tener
*	-> las entradas i salidas de la BBDD tan controladas como deseariamos
*
*/
class DBMongo{
	private $dbUser;              #username para el acceso
	private $dbPass;              #password para el acceso
	private $server;              #servidor al que conectarse
	private $conexion;            #conexion MongoCLient
	private $db;                  #nombre de la base de datos
	private $colectionNow;        #nombre de la coleccion
	/**
	 * [__construct description]
	 *
	 * constructor,  que dada el nombre de la coleccion se conecta a mongo
	 * y selecciona la coleccion
	 * @param string $colection 	Coleccion a la que conectarse
	 */
	function __construct($colection=""){
		$this->conectar();
		$this->selectCollection($colection);
	}
	/**
	 * [conectar description]
	 *
	 * funcion para conectar a la BBDD de mongolab en este caso, devulve la conexion
	 *
	 * ->OJO! aqui no deberian ir las credenciales, habria que utilizar archivo config(que no existe)
	 * -> que por temas de comodidad de momento obviamos
	 * 
	 * @return Object MongoCLient 		devuelve la conexion
	 */
	public function conectar(){
	    $this->dbUser = "txemens";
	    $this->dbPass = "h0lita";
	    $this->db = "viajeros";
	    $this->server = "mongodb://".$this->dbUser.":".$this->dbPass."@ds043329.mongolab.com:43329/viajeros";
	    
	    // $this->server = getenv("MONGO_URL");
	    #conexion en mongolab 
	    $this->conexion = new MongoClient($this->server);
	    #conexion en local
	    //$this->conexion = new MongoClient();
	    return $this->conexion;
	}
	/**
	 * [selectCollection description]
	 *
	 * dado un parametro selecciona la collecion de la db
	 * 
	 * @param  string $colection 	coleccion a seleccionar
	 * @return MongoCollection            	devuelve la coleccion
	 */
	public function selectCollection($colection){
	      $db = $this->db;
		$database = $this->conexion->$db;
		$col = $database->$colection;
		$this->colectionNow = $col;
		return $col;
	}


	/**
	 * [insertar description]
	 *
	 * dado un documento Array lo inserta directamente en la coleccion
	 *
	 * devolvera si ha podido hacerlo o no
	 * 
	 * @param  Array $doc 	Documento a insertar
	 * @return bool      	Si ha podido insertarlo
	 */
	public function insertar($doc){
		$retorn = $this->colectionNow->insert($doc);
		return $retorn["ok"];
	}
    /**
     * [findCollection description]
     *
     * funcion que ejecuta la funcion find de mongo, pero en vez de devolver
     * MongoCursor devuelve un array mutildimensional
     *
     *	->Si no existe $query, lo devuelve todo
     * 	->Si no existe campos, los muestra todos
     * 
     * @param  Array  $query  array con los valores a buscar
     * @param  array  $campos array con los valores a mostrar
     * @return Array[]        Array multidimensional con los valores encontrados
     */
	public function findCollection($query="", $campos = array()){
		if($query=="") $cursor = $this->colectionNow->find();
		else $cursor = $this->colectionNow->find($query, $campos);
		$retorn = array();
		while ($cursor->hasNext()) 
		      $retorn[] = $cursor->getNext();
		
		return $retorn;
	}
	/**
	 * [contar description]
	 *
	 * cuenta el numero de documentos de la colleccion que tienen 
	 * como propiedades la query
	 *
	 * ->si no existe $query, contara el numero de documentos total
	 * 
	 * @param  Array $query 	parametros de la cuenta
	 * @return int  	      	numero de documentos encontrados
	 */
	public function contar($query=""){
		if($query=="") return $this->colectionNow->count();
	      else return $this->colectionNow->count($query);
	}
	/**
	 * [eliminar description]
	 *
	 *	Dado un parametro de busqueda borrara todos los campos que encuentre con esos parametros
	 *
	 * -> el parametro ha $query ha de exisistir obligatoriamente
	 * 
	 * @param  array $query 	parametros a buscar
	 * @param  array $opt      opciones de borrado
	 * @return bool             devuelve si ha conseguido borrarlos
	 */
	public function eliminar($query, $opt=""){
	      $retorn = 0;
		if($opt=="") $retorn = $this->colectionNow->remove($query);
		else $retorn = $this->colectionNow->remove($query, $opt);
		
		return $retorn["ok"];
	}
	/**
	 * [actualiza description]
	 *
	 *	dado dos parametros, el de busqueda i los nuevos datos, hace un update
	 *	en los documentos encontrados por la $query con los datos nuevo
	 * 
	 * @param  Array  $query   documento a buscar
	 * @param  Array  $newData nuevos datos
	 * @param  Array  $opt     opciones de actualizado
	 * @return bool            retorna si ha sido concluyente
	 */
	public function actualiza($query, $newData,$opt="+"){
            
	      $retorn = 0;
	      if($opt=="+") $retorn = $this->colectionNow->update($query, $newData);
		else $retorn = $this->colectionNow->update($query, $newData, $opt);
	      return $retorn["ok"];
	}
	/**
	 * [getCollection description]
	 *
	 * devuelve la colleccion 
	 * 
	 * @return MongoCollection 
	 */
	public function getCollection(){
		return $this->colectionNow;
	}

	/**
	 * [findOneCollection description]
	 *
	 *	funcion que ejecuta la funcion findone de mongo, pero en vez de devolver
     * MongoCursor devuelve un array mutildimensional
     * y solo devuelve un campo
	 *
	 * ->Cogemos las excepciones por la cantidad de errores que a veces devuelve
	 * 
     * @param  Array  $query  array con los valores a buscar
     * @param  array  $campos array con los valores a mostrar
     * @return Array[]        Array multidimensional con los valores encontrados
	 */
	public function findOneCollection($query="", $mostrar=""){
	      try {
		      $retorn = array();
		      if($query=="") $retorn= $this->colectionNow->findOne();
		      else{
		            if($mostrar=="") $retorn= $this->colectionNow->findOne($query);
		            else $retorn=$this->colectionNow->findOne($query, $mostrar);
		      } 
	      return $retorn;
	      }
            catch (MongoCursorException $e) {
                echo "error message: ".$e->getMessage()."\n";
                echo "error code: ".$e->getCode()."\n";
            }
	}
}

?>