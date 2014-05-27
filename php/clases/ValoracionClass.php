<?php
      require_once("ClassMongoClient.php");
	
	/**
	* 
	*/
	class Valoracion{
		private $user = null;
		private $object = null;
            private $bbdd;
            private $arrayValor;
            
            function __construct($bbdd){
			$this->bbdd = new DBMongo($bbdd);
		}
		
            public function getUser() {return $this->user;}
            public function setUser($user) {$this->user = $user;}
            public function getObject() {return $this->object;}
            public function setObject($object) {$this->object = $object;}
            
            public function valoracionToArray(){
                  $this->arrayValor = array(
                        "user"=> $this->user,
                        "object"=> $this->object
                  );
            }
            public function verValoraciones(){
                  $query = array("object"=>$this->object);
                  return $this->bbdd->contar($query);
            }
            public function insertValoracion(){
                  $retorn = 0;
                  if(!$this->comproveValoracion) 
                        $retorn = $this->bbdd->insertar($this->arrayValor);
                  
                  return $retorn;
            }
            public function comproveValoracion(){
                  $this->valoracionToArray;
                  return $this->bbdd->contar($this->arrayValor);
            }
	}
?>
