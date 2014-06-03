<?php


 require_once("ClassMongoClient.php");
	/**
	* 
	*/
	class Pregunta{
		
		private $id = null;
		private $user = null;
		private $pregunta = null;
		private $idSitio = null;
		private $bbdd;
		
		function __construct($bbdd){
		      $this->bbdd = new DBMongo($bbdd);
		}
      	
      	public function getId(){return $this->id;}
            public function setId($id){$this->id = $id;}
            public function getUser(){return $this->user;}
            public function setUser($user){$this->user = $user;}
            public function getPregunta(){return $this->pregunta;}
            public function setPregunta($pregunta){$this->pregunta = $pregunta;}
            public function getIdSitio(){return $this->idSitio;}
            public function setIdSitio($idSitio){$this->idSitio = $idSitio;}
            
            public function cogeValoresSegunId(){
		      $queryForId = array('_id' => $this->id);
	      	if($this->bbdd->contar($queryForId)){
		      	$coment = $this->bbdd->findOneCollection($queryForId);
			      $this->id = $coment['_id'];
			      $this->usuario = $coment['idUsu'];
		            $this->idSitio= (isset($coment['idCiu']))? $coment['idCiu'] : $coment['idPais'];
		     }
	      }
            public function borrarPregunta(){
                  $queryForDelete = array("_id"=>new MongoId($this->id));
                  return  $this->bbdd->eliminar($queryForDelete);
            }
            public function devolverDelSitio($tipo){
                  if($tipo == "Pais")
                        $query = array("idPais" =>new MongoId($this->idSitio));
                  elseif($tipo = "Ciudad")
                        $query = array('idCiu'=>new MongoId($this->idSitio));
                  //var_dump($this->bbdd->findCollection($query));
                  //$queryForView = array("_id"=>false, "valor"=>true);
                  return  $this->bbdd->findCollection($query);
            }
            public function insertarPregunta($tipo){
                  $queryForInsert = array("idUsu"=>$this->user, 
                                    "pregunta"=>$this->pregunta);
                  if($tipo == "Ciudad") $queryForInsert["idCiu"]= $this->idSitio;
                  elseif($tipo == "Pais") $queryForInsert["idPais"]= $this->idSitio;
                  
                  return $this->bbdd->insertar($queryForInsert);
            }
	}

?>