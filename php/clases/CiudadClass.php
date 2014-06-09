<?php
require_once("ClassMongoClient.php");
/**
*	Clase Ciudad
* 
*     bbdd              ->          base de datos ciudades
* 	  id                ->          id de la ciudad
*     nombre            ->          nombre de la ciudad
*     coordenadas       ->          coordenadas de la ciudad
*     pais 				->			pais al que pertenece
*     ciudadInArray		->			atributos de la ciudad formato array
*/

class Ciudad{
	private $bbdd;
	private $id = null;
	private $nombre = null;
	private $coordenadas = null;
    private $pais = null;
	private $ciudadInArray;
	/**
	 * constructor
	 *
	 * su unico objetivo es conectarse a la bbdd de mongo->colleccion->ciudades
	 * y guarda en $bbdd mongoCollection
	 */
	function __construct(){
	    $this->bbdd = new DBMongo("ciudad");
	}

	/**
	 * getters and setters
	 */
	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getNombre(){return $this->nombre;}
	public function setNombre($nombre){$this->nombre = $nombre;}
	public function getCoordenadas(){return $this->coordenadas;}
	public function setCoordenadas($coordenadas){$this->coordenadas = $coordenadas;}
	public function getPais(){return $this->pais;}
	public function setPais($pais){$this->pais = $pais;}

    /**
     * comprueba que una ciudad exista en la BBDD
     * @return boolean 		0 si no existe, 1=< si existe 
     */
	public function ciudadIfExistInBBDD(){
		return $this->bbdd->contar($this->ciudadInArray);
	}
	/**
	 * [guardarCiudad description]
	 *
	 * 	funcion que guarda la ciudad en la bbdd si no existe
	 * 	
	 * @return bool  	1 si la guarda, 0 si no la guarda 
	 */
	public function guardarCiudad(){
	    $retorn = 0;
	    #pasamos los valores a array para hacer la consulta
	    $this->ciudadToArray();
		if(!$this->ciudadIfExistInBBDD()){
			$this->bbdd->insertar($this->ciudadInArray);
			$retorn = 1;
		}
		return $retorn;
	}
	/**
	 * [ciudadToArray description]
	 * 
	 * funcion que pasa las propiedades del objeto a formato array
	 * lo guarda en la propiedad ciudadInArray
	 */
    public function ciudadToArray(){
		$this->ciudadInArray = array(
      			'_id' => $this->id,
      			'ciudad' => $this->nombre,
      			'coordenadas' => $this->coordenadas,
      			
      			'pais' =>  $this->pais
			);
	}
     
    /**
     * [cogeValoresSegunId description]
     *
     * cogiendo de base solo el id de la ciudad, busca en la BBDD y guarda 
     * la informacion en sus respectivas propiedades
     *
     * primero comprueva si existe, si no existe, ni lo intenta
     */
	public function cogeValoresSegunId(){
		$queryForId = array('_id' => new MongoId($this->id));
		if($this->bbdd->contar($queryForId)){
			$user = $this->bbdd->findOneCollection($queryForId);
			
			$this->nombre = $user['ciudad'];
		      $this->coordenadas = $user["coordenadas"];
			$this->pais = $user['pais'];
		}
	}
	/**
	 * [buscarCiudad description]
	 *
	 * dado un parametro, busca por tipo de parametro dentro de la BBDD y guarda los campos
	 *
	 * TO DO:
	 * 		case user
	 * 		case coord
	 * 
	 * @param  string $opt 	opcion de busqueda
	 */
	public function buscarCiudad($opt){
	      switch($opt){
	            case "ciudad":
	                        $query = array("ciudad"=>$this->nombre, "pais"=>$this->pais);
	                        $ciudad = $this->bbdd->findOneCollection($query);
	                        $this->id= $ciudad['_id'];
	                        break;
	            case "user": $this->cogeValoresSegunId(); break;
	            case "coord": break;
	      }
	}
	
}
?>