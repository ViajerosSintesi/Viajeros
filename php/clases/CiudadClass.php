<?php
require_once("ClassMongoClient.php");
/**
*	###################################################
*	de momento en la BBDD la ciudad tiene este formato:
*
* 	{
* 		"_id": codigo de la ciudad,
* 		"nombre": string,
* 		"coordx": password,
* 		"coordy": int,
* 	  	"pais": pais al que pertence
* 	}
* 	
*  ######################################################
* 	
*/
class Ciudad{
	private $bbdd;
	private $id = null;
	private $nombre = null;
	private $coordenadax = null;
	private $coordenaday = null;
      private $pais = null;
	private $ciudadInArray;
	
	function __construct(){
	    $this->bbdd = new DBMongo("ciudades");
	}

	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getNombre(){return $this->nombre;}
	public function setNombre($nombre){$this->nombre = $nombre;}
	public function getCoordenadax(){return $this->coordenadax;}
	public function setCoordenadax($coordenadax){$this->coordenadax = $coordenadax;}
	public function getCoordenaday(){return $this->coordenaday;}
	public function setCoordenaday($coordenaday){$this->coordenaday = $coordenaday;}
	public function getPais(){return $this->pais;}
	public function setPais($pais){$this->pais = $pais;}

    
	public function ciudadIfExistInBBDD(){
		return $this->bbdd->contar($this->ciudadInArray);
	}

	public function guardarCiudad(){
	    $retorn = 0;
	    $this->ciudadToArray();
		if(!$this->ciudadIfExistInBBDD()){
			$this->bbdd->insertar($this->ciudadInArray);
			$retorn = 1;
		}
		return $retorn;
	}
      public function ciudadToArray(){
		$this->ciudadInArray = array(
      			'_id' => $this->id,
      			'nombre' => $this->nombre,
      			'coordenadax' => $this->coordenadax,
      			'coordenaday' => $this->coordenaday,
      			'pais' =>  $this->pais
			);
	}
     
	public function cogeValoresSegunId(){
		$queryForId = array('_id' => $this->id);
		if($this->bbdd->contar($queryForId)){
			$user = $this->bbdd->findOneCollection($queryForId);
			
			$this->nombre = $user['nombre'];
			$this->coordenadax = $user['coordenadax'];
			$this->coordenaday = $user['coordenaday'];
			$this->pais = $user['pais'];

		}
	}
	
	
	
}
?>