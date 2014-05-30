<?php
      require_once("ClassMongoClient.php");
	
	/**
	* 
	*/
	class Valoracion{
		private $user = null;
		private $object = null;
		private $valor = null;
		
            private $bbdd;
            private $arrayValor;
            
            function __construct($bbdd){
			$this->bbdd = new DBMongo($bbdd);
		}
		
            public function getUser() {return $this->user;}
            public function setUser($user) {$this->user = $user;}
            public function getObject() {return $this->object;}
            public function setObject($object) {$this->object = $object;}
            public function getValor() {return $this->valor;}
            public function setValor($valor) {$this->valor = $valor;}
            
            
            public function valoracionToArray(){
                  $this->arrayValor = array(
                        "user"=> $this->user,
                        "object"=> $this->object,
                        "valor"=>$this->valor
                  );
            }
            
            public function verValoraciones(){
                  $query = array("object"=>$this->object);
                  $queryForView = array("_id"=>false, "valor"=>true);
                  return $this->bbdd->findCollection($query,$queryForView);
            }
            public function insertValoracion($compr=true){
                  $retorn = 0;
                  $this->valoracionToArray();
                  if($compr){
                        if(!$this->comproveValoracion())
                              $retorn = $this->bbdd->insertar($this->arrayValor);
                  }else{
                        $queryForSearch = array("user"=> $this->user, 
                                                "object"=>$this->object);
                        $this->bbdd->eliminar($queryForSearch);
                        $retorn = $this->bbdd->insertar($this->arrayValor);
                  }
                  return $retorn;
            }
            public function comproveValoracion(){
                  $queryForSearch = array("user"=> $this->user, 
                                          "object"=>$this->object);
                  return $this->bbdd->contar($queryForSearch);
            }
            public function verValoracionDelUsuario(){
                  $query = array("user"=> $this->user, 
                                 "object"=>$this->object);
                  $queryForView = array("_id"=>false, "valor"=>true);
                  return $this->bbdd->findOneCollection($query,$queryForView);
            }
	}
?>
