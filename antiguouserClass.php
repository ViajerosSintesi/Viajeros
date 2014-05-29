<?php
require_once("ClassMongoClient.php");
require_once("CorreoClass.php");
/**
 * 
 * 
*	###################################################
*	de momento en la BBDD el usuario tiene este formato:
*
* 	{
* 		id: mail,
* 		username: string,
* 		pass: password,
* 		edad: int,
* 	  	email: mail->redundante?
*           activado:bool,
*           codActivacion: uniqId()
*           imgPerfil: path to image
* 	}
* 	ha medida que se vaya agrandando hay que meter mas informacion
* 	como ciudades, baneos, etc...
*  ######################################################
* 	
*/

class User{
	private $bbdd;                            #conexion a la BBDD de usuarios
	private $id = null;                       #id del usuario, tambien email
	private $username = null;                 #nombre del usuario
	private $password = null;                 #password
	private $edad = null;                     #edad del usuario
	private $activado = null;                 #saber si esta activado o no la cuenta
	private $codActivacion = null;            #codigo para activar la cuenta-> base64 del email
	private $imgPerfil = null;                #ruta hacia la foto de perfil
	//private $email = null;
	private $userInArray;                     #array con todos los datos, facilita las querys a mongo
	
	/**
	 * Constructor
	 * 
	 * Lo uninco se conecta a la BBDD coleccion usuarios
	 **/
	function __construct(){
	    $this->bbdd = new DBMongo("usuarios");
	}
      /**
       * Gettters and setters!
       * 
       * */
	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getUsername(){return $this->username;}
	public function setUsername($username){$this->username = $username;}
	
	#Password encriptado en md5
	public function getPassword(){return md5($this->password);}
	public function setPassword($password){$this->password = md5($password);}
	public function getEdad(){return $this->edad;}
	public function setEdad($edad){$this->edad = $edad;}
	public function getActivado(){return $this->activado;}
	public function setActivado($activado){$this->activado = $activado;}
	#activacion encriptada en base64!
	public function getCodActivacion(){return $this->codActivacion;}
	public function setCodActivacion($CodActivacion){$this->codActivacion = base64_encode($CodActivacion);}
	public function getImgPerfil(){return $this->imgPerfil;}
	public function setImgPerfil($imgPerfil){$this->imgPerfil = $imgPerfil;}
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
			'codActivacion' => $this->codActivacion,
                  'imgPerfil' => $this->imgPerfil
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
			$this->imgPerfil = $user['imgPerfil'];

		}
	}
	public function enviaEmailConfirm(){
            
		$url = "https://viajeros-c9-txemens.c9.io/php/controlRegistro.php?verificar=".$this->codActivacion;
		$plantilla = file_get_contents("../plantillas/email.html");
		$diccionario = array('username' => $this->username,'url' => $url );
		$mail = new Correo($diccionario, $plantilla, $this->id, "Bienvenido!", "no-reply@viajeros.com");
		$mail->enviarMail();
	}
	public function activarUser(){
	      $this->userToArray();
	      $nuevosDatos = array('$set' => array("activado" => 1));
	      $queryForUp = array('_id' => $this->id);
	      $this->bbdd->actualiza($queryForUp,$nuevosDatos);
	}
	public function ponerImgPerfil($fileImg){
	    $uploaddir = '../images/fotosPerfil/';
            $uploadfile = $uploaddir.basename($fileImg['userfile']['name']);
            
            if (move_uploaded_file($fileImg['userfile']['tmp_name'], $uploadfile)) {
                $this->setImgPerfil($uploadfile);
            }  
	}
	public function updateUser($id=""){
	      if($id=="") $queryForId = array('_id' => $this->id);
	      else $queryForId = array('_id' => $id);
	      
	      $nuevosDatos = array('$set' => $this->userInArray);
	      $this->bbdd->actualiza($queryForId, $nuevosDatos);
	}
	
}
?>