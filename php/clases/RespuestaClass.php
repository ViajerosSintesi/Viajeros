<?php


 require_once("ClassMongoClient.php");
/**
* 
*/
class Respuesta{
	
	private $id = null;
	private $user = null;
	private $idPregunta = null;
      private $respuesta = null;
	private $idSitio = null;
	private $bbdd;
	
	function __construct($bbdd){
	      $this->bbdd = new DBMongo($bbdd);
	}
	
      public function getId(){return $this->id;}
      public function setId($id){$this->id = $id;}
      public function getUser(){return $this->user;}
      public function setUser($user){$this->user = $user;}
      public function getIdPregunta(){return $this->idPregunta;}
      public function setIdPregunta($idPregunta){$this->idPregunta = $idPregunta;}
      public function getRespuesta(){return $this->respuesta;}
      public function setRespuesta($respuesta){$this->respuesta = $respuesta;}
      public function getIdSitio(){return $this->idSitio;}
      public function setIdSitio($idSitio){$this->idSitio = $idSitio;}

      
      public function cogeValoresSegunId(){
	      $queryForId = array('_id' => $this->id);
      	if($this->bbdd->contar($queryForId)){
	      	$respuesta = $this->bbdd->findOneCollection($queryForId);
		      $this->id = $respuesta['_id'];
		      $this->usuario = $respuesta['idUsu'];
	            $this->idSitio= (isset($respuesta['idCiu']))? $respuesta['idCiu'] : $respuesta['idPais'];
	            $this->idPregunta= $respuesta['idPregunta'];
	     }
      }
      public function borrarRespuesta(){
            $queryForDelete = array("_id"=>new MongoId($this->id));
            return  $this->bbdd->eliminar($queryForDelete);
      }
      public function devolverDeLaPregunta($tipo){
            if($tipo == "Pais")
                  $query = array("idPais" =>new MongoId($this->idSitio));
            elseif($tipo = "Ciudad")
                  $query = array('idCiu'=>new MongoId($this->idSitio));
            $queryForInsert["idPregunta"] = $this->idPregunta;
            //var_dump($this->bbdd->findCollection($query));
            //$queryForView = array("_id"=>false, "valor"=>true);
            return  $this->bbdd->findCollection($query);
      }
      public function insertarRespuesta($tipo){
            $queryForInsert = array("idUsu"=>$this->user, 
                              "pregunta"=>$this->pregunta);
            if($tipo == "Ciudad") $queryForInsert["idCiu"]= $this->idSitio;
            elseif($tipo == "Pais") $queryForInsert["idPais"]= $this->idSitio;
            $queryForInsert["idPregunta"] = $this->idPregunta;
            return $this->bbdd->insertar($queryForInsert);
      }
}

?>