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
	private $coordenadas = null;
      private $pais = null;
	private $ciudadInArray;
	
	function __construct(){
	    $this->bbdd = new DBMongo("ciudad");
	}

	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getNombre(){return $this->nombre;}
	public function setNombre($nombre){$this->nombre = $nombre;}
	public function getCoordenadas(){return $this->coordenadas;}
	public function setCoordenadas($coordenadas){$this->coordenadas = $coordenadas;}
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
      			'ciudad' => $this->nombre,
      			'coordenadax' => $this->coordenadax,
      			'coordenaday' => $this->coordenaday,
      			'pais' =>  $this->pais
			);
	}
     
	public function cogeValoresSegunId(){
		$queryForId = array('_id' => new MongoId($this->id));
	
            
		if($this->bbdd->contar($queryForId)){
			$user = $this->bbdd->findOneCollection($queryForId);
			
			$this->nombre = $user['ciudad'];
		
			$this->pais = $user['pais'];

		}
	}
	
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