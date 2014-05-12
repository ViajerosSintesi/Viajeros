<?php
require_once("ClassMongoClient.php");
/**
*	###################################################
*	de momento en la BBDD el usuario tiene este formato:
*
* 	{
* 		id: mail,
* 		username: string,
* 		pass: password,
* 		edad: int,
* 	  	email: mail->redundante?
*       activado:bool,
*       codActivacion: uniqId()
* 	}
* 	ha medida que se vaya agrandando hay que meter mas informacion
* 	como ciudades, baneos, etc...
*  ######################################################
* 	
*/
class User{
	private $bbdd;
	private $id = null;
	private $nombre = null;
	private $poblacion = null;
	private $lengua = null;
	private $usuarios_id = null;

	private $ciudadesInArray;
	
	function __construct(){
	    $this->bbdd = new DBMongo("ciudades");
	}

	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getnombre(){return $this->nombre;}
	public function setnombre($nombre){$this->nombre = $nombre;}
	public function getpoblacion(){return $this->poblacion;}
	public function setpoblacion($poblacion){$this->poblacion = $poblacion;}
	public function getlengua(){return $this->lengua;}
	public function setlengua($lengua){$this->lengua = $lengua;}
	public function getusuarios_id(){return $this->usuarios_id;}
	public function setusuarios_id($usuarios_id){$this->usuarios_id = $usuarios_id;}
	//public function getEmail(){return $this->email;}
	//public function setEmail($email){$this->email = $email;}
    
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
			'poblacion' => $this->poblacion,
			'lengua' => $this->lengua,
			'usuarios_id' => $this->usuarios_id

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
			$this->poblacion = $user['poblacion'];
			$this->lengua = $user['lengua'];
			$this->usuarios_id = $user['usuarios_id'];

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