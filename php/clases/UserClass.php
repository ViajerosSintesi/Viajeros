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
	//private $email = null;
	private $userInArray;
	
	function __construct(){
	    $this->bbdd = new DBMongo("usuarios");
	}

	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getUsername(){return $this->username;}
	public function setUsername($username){$this->username = $username;}
	public function getPassword(){return $this->password;}
	public function setPassword($password){$this->password = $password;}
	public function getEdad(){return $this->edad;}
	public function setEdad($edad){$this->edad = $edad;}
	//public function getEmail(){return $this->email;}
	//public function setEmail($email){$this->email = $email;}
    
	public function userIfExistInBBDD(){
		return $this->bbdd->contar($this->userInArray);
	}

	public function guardarUser(){
	    $this->userToArray();
		if(!$this->userIfExistInBBDD()){
			$this->bbdd->insertar($this->userInArray);
		}
	}
      public function userToArray(){
		$this->userInArray = array(
			'_id' => $this->id,
			'username' => $this->username,
			'pass' => $this->password,
			'edad' => $this->edad
			//'email' => $this->email
			);
	}
      public function comproveLogin(){
	    $queryForId = array('_id' => $this->id);
	    $retorn = 0;
	    if($this->bbdd->contar($queryForId)){
	    	$queryForPass = array('_id' => $this->id,'pass' => $this->password);
	    	if($this->bbdd->contar($queryForPass)){
	    		$retorn = 1;
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
			$this->pass = $user['pass'];

		}
	}
}
?>