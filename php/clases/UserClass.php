<?php
require_once("ClassMongoClient.php");

/**
*	###################################################
*	de momento en la BBDD el usuario tiene este formato:
*
* 	{
* 		id: mail,
* 		username: string,
*           apellidos: string
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
	private $bbdd;
	private $id = null;
	private $username = null;
	private $apellidos = null;
	private $password = null;
	private $edad = null;
	private $activado = null;
	private $codActivacion = null;
	private $imgPerfil = null;
	//private $email = null;
	private $userInArray;
	
	function __construct(){
	    $this->bbdd = new DBMongo("usuarios");
	}

	public function getId(){return $this->id;}
	public function setId($id){$this->id = $id;}
	public function getUsername(){return $this->username;}
	public function setUsername($username){$this->username = $username;}
	public function getApellidos(){return $this->apellidos;}
	public function setApellidos($apellidos){$this->apellidos = $apellidos;}
	public function getPassword(){return $this->password;}
	public function setPassword($password){$this->password = md5($password);}
	public function getEdad(){return $this->edad;}
	public function setEdad($edad){$this->edad = $edad;}
	public function getActivado(){return $this->activado;}
	public function setActivado($activado){$this->activado = $activado;}
	public function getCodActivacion(){return $this->codActivacion;}
	public function setCodActivacion($CodActivacion){$this->codActivacion = base64_encode($CodActivacion);}
	public function getImgPerfil(){return $this->imgPerfil;}
	public function setImgPerfil($imgPerfil){$this->imgPerfil = $imgPerfil;}
	//public function getEmail(){return $this->email;}
	//public function setEmail($email){$this->email = $email;}
    
    /**
     * userIfExistInBBDD
     *
     * devuelve el numero de filas que existen identicas al usuario
     * 
     * @return int   valor numerico de filas identicas
     */
	public function userIfExistInBBDD(){
		return $this->bbdd->contar($this->userInArray);
	}

	/**
	 *	funccion para guardar el usuario en la BBDD->usuarios
	 *	lo vuelve array, is si no existe en la BBDD lo inserta como campo nuevo
	 *	
	 * @return int  codigo para saber si lo ha guardado o no
	 *                     0: no guardado
	 *                     1: guardado
	 */
	public function guardarUser(){
	    $retorn = 0;
	    $this->userToArray();
		if(!$this->userIfExistInBBDD()){
			$this->bbdd->insertar($this->userInArray);
			$retorn = 1;
		}
		return $retorn;
	}
	/**
	 * funcion para crear un array asociativa con los valores del usuario
	 * y las mismas claves que las de la tabla usuario de mongo
	 *
	 * se guarda en la propiedad userInArray
	 */
    public function userToArray(){
		$this->userInArray = array(
			'_id' => $this->id,
			'username' => $this->username,
			'apellidos' => $this->apellidos,
			'pass' => $this->password,
			'edad' => $this->edad,
			'activado' => $this->activado,
			'codActivacion' => $this->codActivacion,
                  'imgPerfil' => $this->imgPerfil
			//'email' => $this->email
			);
	}

	/**
	 * Comprueva que se puede loguear
	 * primero mira si existe el id en la BBDD
	 * si existe, comprueva que el id i el pass esten en el mismo documento
	 * si id y pass estan, comprueba que el usuario esta activado
	 *
	 * @return int codigo para comprovar:
	 *                    cod 0: no existe el mail
	 *                    cod 1: existe el mail, password y esta activado
	 *                    cod 2: existe el mail i el password pero no esta activado
	 */
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

	/**
	 * segun el id el user, cogera todo los demas valores de la BBDD
	 * si existe, los buscara y rellenara las propiedades
	 *  
	 * @return int codigo para comprovar:
	 *                    cod 0: no existe el id en la BBDD
	 *                    cod 1: se a podido buscar i completar las propiedades
	 */
	public function cogeValoresSegunId(){
		$retorn = 0;
		$queryForId = array('_id' => $this->id);
		if($this->bbdd->contar($queryForId)){
			$user = $this->bbdd->findOneCollection($queryForId);
			
			$this->username = $user['username'];
			$this->apellidos = $user['apellidos'];
			$this->edad = $user['edad'];
			$this->password = $user['pass'];
			$this->activado = $user['activado'];
			$this->codActivacion = $user['codActivacion'];
			$this->imgPerfil = $user['imgPerfil'];
			$retorn = 1;
		}
		return $retorn;
	}
	/**
	 * Al registrarse un usuario nuevo es necesario que active la cuenta
	 * este metodo crea un nuevo correo y lo envia al usuario
	 * 
	 */
	public function enviaEmailConfirm(){
		#libreria para la clase correo
        require_once("CorreoClass.php");
        #url que dentro del email tiene que clickar para activar la cuenta
		$url = "http://viajeros.herokuapp.com/php/controles/controlRegistro.php?verificar=".$this->codActivacion;
		#plantilla del email
		$plantilla = file_get_contents("../../plantillas/email.html");
		#palabras claves dentro del mail
		$diccionario = array('username' => $this->username,'url' => $url );
	
		#creacion del correo y envio
		$mail = new Correo($diccionario, $plantilla, $this->id, "Bienvenido!", "no-reply@viajeros.com");
		$mail->enviarMail();
	}

	/**
	 * activar usuario
	 * cambia el valor de 0 a 1 del campo "activado" de la tabla user 
	 */
	public function activarUser(){
	      $this->userToArray();
	      $nuevosDatos = array('$set' => array("activado" => 1));
	      $queryForUp = array('_id' => $this->id);
	      $this->bbdd->actualiza($queryForUp,$nuevosDatos);
	}
	/**
	 * guarda la imagen de perfil en el servidor, por defecto "images/fotosPerfil/"
	 * si la consigue mover, se guarda como propiedad la ruta de la imagen
	 *
	 * --->Ojo! no la guarda en la BBDD<---
	 * 
	 * @param  file 	$fileImg 	archivo de la imagen, se le entrega->$_FILES
	 */
	public function ponerImgPerfil($fileImg){
	      $retorn = 0;
	      
	      $uploaddir = '../../images/fotosPerfil/';

            if (!file_exists($uploaddir)) 
                mkdir($uploaddir, 0777, true);
                
            $uploadfile = $uploaddir.basename($fileImg['name']);
            
            if (move_uploaded_file($fileImg['tmp_name'], $uploadfile)) {
                #borra la antigua imagen
                $antiguoPath=$this->bbdd->findOneCollection(array("_id"=>$this->id), array("imgPerfil"));
                
                if(file_exists($antiguoPath['imgPerfil'])) unlink($antiguoPath['imgPerfil']);
                //echo file_exists($uploadfile);
                $this->setImgPerfil($uploadfile);
                $queryForId = array('_id' => $this->id);
                $queryForChange = array('$set'=> array('imgPerfil' =>$uploadfile));
                $this->bbdd->actualiza($queryForId, $queryForChange);
                $retorn=1;
            }
            return $retorn;
	}

	/**
	 * metodo que actualiza las propiedades actuales en la BBDD
	 *
	 * si se le pasa una id, actualizara la id como parametro,
	 * en cambio si no, actualizara la id que esta como propiedad
	 * 
	 * @param  string $id 	id a actualizar
	 */
	public function updateUser($id=""){
	      
	      if($id=="") $queryForId = array('_id' => $this->id);
	      else {
	            $queryForId = array('_id' => $id);
	            $this->id = $id;
	      }
	      
	      $this->bbdd->eliminar($queryForId);
	      return $this->guardarUser();
	}
	
}
?>