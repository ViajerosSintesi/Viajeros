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
class User{
	private $bbdd;
	private $id = null;
	private $nombre = null;
	private $coordenadax = null;
	private $coordenaday = null;

	private $ciudadesInArray;
	
	function __construct(){
	    $this->bbdd = new DBMongo("ciudades");
	}

	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getnombre(){return $this->nombre;}
	public function setnombre($nombre){$this->nombre = $nombre;}
	public function getcoordenadax(){return $this->coordenadax;}
	public function setcoordenadax($coordenadax){$this->coordenadax = $coordenadax;}
	public function getcoordenaday(){return $this->coordenaday;}
	public function setcoordenaday($coordenaday){$this->coordenaday = $coordenaday;}

    
	public function ciudadesIfExistInBBDD(){
		return $this->bbdd->contar($this->ciudadesInArray);
	}

	public function guardarciudades(){
	    $retorn = 0;
	    $this->ciudadesToArray();
		if(!$this->ciudadesIfExistInBBDD()){
			$this->bbdd->insertar($this->ciudadesInArray);
			$retorn = 1;
		}
		return $retorn;
	}
      public function ciudadesToArray(){
		$this->ciudadesInArray = array(
			'_id' => $this->id,
			'nombre' => $this->nombre,
			'coordenadax' => $this->coordenadax,
			'coordenaday' => $this->coordenaday,

			);
	}
      /*public function comproveLogin(){
	    $queryForId = array('_id' => $this->id);
	    $retorn = 0;
	    if($this->bbdd->contar($queryForId)){
	    	$queryForPass = array('_id' => $this->id,'pass' => $this->password);
	    	if($user = $this->bbdd->findOneCollection($queryForPass)){
	    	      if($user["activado"]){
	    	            $retorn = 1;
	    	      }else {$retorn = 2;}
	    	}
	    }
	    return $retorn;
		
	}*/
	
	public function cogeValoresSegunId(){
		$queryForId = array('_id' => $this->id);
		if($this->bbdd->contar($queryForId)){
			$user = $this->bbdd->findOneCollection($queryForId);
			
			$this->nombre = $user['nombre'];
			$this->coordenadax = $user['coordenadax'];
			$this->coordenaday = $user['coordenaday'];

		}
	}
	
	/*
	public function enviaEmailConfirm(){

		$url = "https://viajeros-c9-txemens.c9.io/php/controlLogin.php?verificar=".$this->codActivacion;
		$cadena = file_get_contents("../email.html");
		$diccionario = array('username' => $this->username,
							 'url' => $url
							);
		foreach ($diccionario as $key => $value) {
			 $cadena = str_replace('['.$key.']',$value,$cadena);
		}

		$cabeceras = 'From: no-reply@viajeros.com' . "\r\n" .
    				'Reply-To: no-reply@viajeros.com' . "\r\n" .
   					 'X-Mailer: PHP/' . phpversion();

		mail($this->id, 'activacion', $cadena, $cabeceras);
	}
	*/
	
}
?>