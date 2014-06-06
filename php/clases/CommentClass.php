<?php

 require_once("ClassMongoClient.php");
	/**
	* 
	*/
	class Comment{
		
		private $id = null;
		private $user = null;
		private $comentario = null;
		private $idSitio = null;
		private $bbdd;
		private $fecha = null;
		
		function __construct($bbdd){
		      $this->bbdd = new DBMongo($bbdd);
		}
      	
      	public function getId(){return $this->id;}
            public function setId($id){$this->id = $id;}
            public function getUser(){return $this->user;}
            public function setUser($user){$this->user = $user;}
            public function getComentario(){return $this->comentario;}
            public function setComentario($comentario){$this->comentario = $comentario;}
            public function getIdSitio(){return $this->idSitio;}
            public function setIdSitio($idSitio){$this->idSitio = $idSitio;}
            public function getFecha(){return $this->fecha;}
            public function setFecha($fecha){$this->fecha = $fecha;}
            
            public function cogeValoresSegunId(){
		      $queryForId = array('_id' => $this->id);
	      	if($this->bbdd->contar($queryForId)){
		      	$coment = $this->bbdd->findOneCollection($queryForId);
			      $this->id = $coment['_id'];
			      $this->usuario = $coment['idUsu'];
		            $this->idSitio= (isset($coment['idCiu']))? $coment['idCiu'] : $coment['idPais'];
		            $this->fecha = $coment['data'];
		     }
	      }
            public function borrarComent(){
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
            public function insertarComent($tipo){
                  $queryForInsert = array("idUsu"=>$this->user, 
                                          "comentario"=>$this->comentario,
                                          "data"=> $this->fecha);
                  if($tipo == "Ciudad") $queryForInsert["idCiu"]= $this->idSitio;
                  elseif($tipo == "Pais") $queryForInsert["idPais"]= $this->idSitio;
                  
                  return $this->bbdd->insertar($queryForInsert);
            }
	}
?>