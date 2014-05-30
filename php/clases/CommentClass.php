<?php

 require_once("ClassMongoClient.php");
	/**
	* 
	*/
	class Comment{
		
		private $user = null;
		private $comentario = null;
		private $idSitio = null;
		private $bbdd;
		private $arrayComment;
		
		function __construct($bbdd){
		      $this->bbdd = new DBMongo($bbdd);
		}
      	
            public function getUser(){return $this->user;}
            public function setUser($user){$this->user = $user;}
            public function getComentario(){return $this->comentario;}
            public function setComentario($comentario){$this->comentario = $comentario;}
            public function getIdSitio(){return $this->idSitio;}
            public function setIdSitio($idSitio){$this->idSitio = $idSitio;}
            
            public function devolverDelSitio($tipo){
                  if($tipo == "Pais")
                        $query = array("idPais" =>new MongoId($this->idSitio));
                  elseif($tipo = "Ciudad")
                        $query = array('idCiu'=>new MongoId($this->idSitio));
                  //var_dump($this->bbdd->findCollection($query));
                  //$queryForView = array("_id"=>false, "valor"=>true);
                  return  $this->bbdd->findCollection($query);
            }
	}
?>