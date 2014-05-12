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
	private $username = null;
	private $password = null;
	private $edad = null;
	private $activado = null;
	private $codActivacion = null;
	//private $email = null;
	private $userInArray;
	
	function __construct(){
	    $this->bbdd = new DBMongo("usuarios");
	}

	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getUsername(){return $this->username;}
	public function setUsername($username){$this->username = $username;}
	public function getPassword(){return md5($this->password);}
	public function setPassword($password){$this->password = md5($password);}
	public function getEdad(){return $this->edad;}
	public function setEdad($edad){$this->edad = $edad;}
	public function getActivado(){return $this->activado;}
	public function setActivado($activado){$this->activado = $activado;}
	public function getCodActivacion(){return $this->codActivacion;}
	public function setCodActivacion($CodActivacion){$this->codActivacion = $CodActivacion;}
	//public function getEmail(){return $this->email;}
	//public function setEmail($email){$this->email = $email;}
    
	public function userIfExistInBBDD(){
		return $this->bbdd->contar($this->userInArray);
	}

	public function guardarUser(){
	      $retorn = 0;
	    $this->userToArray();
		if(!$this->userIfExistInBBDD()){
			$this->bbdd->insertar($this->userInArray);
			$retorn = 1;
		}
		return $retorn;
	}
      public function userToArray(){
		$this->userInArray = array(
			'_id' => $this->id,
			'username' => $this->username,
			'pass' => $this->password,
			'edad' => $this->edad,
			'activado' => $this->activado,
			'codActivacion' => $this->codActivacion

			//'email' => $this->email
			);
	}
      public function comproveLogin(){
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
	}
	public function cogeValoresSegunId(){
		$queryForId = array('_id' => $this->id);
		if($this->bbdd->contar($queryForId)){
			$user = $this->bbdd->findOneCollection($queryForId);
			
			$this->username = $user['username'];
			$this->edad = $user['edad'];
			$this->password = $user['pass'];
			$this->activado = $user['activado'];
			$this->codActivacion = $user['codActivacion'];

		}
	}
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
	
}
?>