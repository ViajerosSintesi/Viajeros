<?php

/**
* 
*/
class DBMongo{
	private $dbUser;
	private $dbPass;
	private $server;
	private $conexion;
	private $db;
	private $colectionNow;
	
	function __construct($colection=""){
		$this->conectar();
		$this->selectCollection($colection);
	}
	
	public function conectar(){
	    $this->dbUser = "txemens";
	    $this->dbPass = "h0lita";
	    $this->db = "viajeros";
	    $this->server = "mongodb://".$this->dbUser.":".$this->dbPass."@ds043329.mongolab.com:43329/viajeros";
	    
	    // $this->server = getenv("MONGO_URL");
	    $this->conexion = new MongoClient($this->server);
	    return $this->conexion;
	}

	public function selectCollection($colection){
	      $db = $this->db;
		$database = $this->conexion->$db;
		$col = $database->$colection;
		$this->colectionNow = $col;
		return $col;
	}

	public function insertar($doc){
		
		return $this->colectionNow->insert($doc);
	}
      
      /**
       * devuelve un array asociativo multidimensional!
       * **/
	public function findCollection($query="", $campos = array()){
		if($query=="") $cursor = $this->colectionNow->find();
		else $cursor = $this->colectionNow->find($query, $campos);
		$retorn = array();
		while ($cursor->hasNext()) 
		      $retorn[] = $cursor->getNext();
		
		return $retorn;
	}

	public function contar($query=""){
		if($query=="") return $this->colectionNow->count();
	      else return $this->colectionNow->count($query);
	}

	public function eliminar($query, $opt=""){
	      $retorn = 0;
		if($opt=="") $retorn = $this->colectionNow->remove($query);
		else $retorn = $this->colectionNow->remove($query, $opt);
		
		return $retorn;
	}

	public function actualiza($query, $newData,$opt="+"){
            
	      $retorn = 0;
	      if($opt=="+") $retorn = $this->colectionNow->update($query, $newData);
		else $retorn = $this->colectionNow->update($query, $newData, $opt);
	      return $retorn;
	}

	public function getCollection(){
		return $this->colectionNow;
	}
	public function findOneCollection($query="", $mostrar=""){
	      try {
	      $retorn = array();
	      if($query=="") $retorn= $this->colectionNow->findOne();
	      else{
	            if($mostrar=="") $retorn= $this->colectionNow->findOne($query);
	            else $retorn=$this->colectionNow->findOne($query, $mostrar);
	      } 
	      return $retorn;
	      }
            catch (MongoCursorException $e) {
                echo "error message: ".$e->getMessage()."\n";
                echo "error code: ".$e->getCode()."\n";
            }
	}
}

?>