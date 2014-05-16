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
		$this->conexion = new Mongo($this->server);
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

	public function findCollection($query=""){
		$cursor = $this->colectionNow->find($query);
		return $cursor;
	}

	public function contar($query=""){
		return $this->colectionNow->count($query);
	}

	public function eliminar($query, $opt=""){
		if($opt=="")$this->colectionNow->remove($query);
		else $this->colectionNow->remove($query, $opt);
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
	      $retorn = "";
	      if($query=="") $retorn= $this->colectionNow->findOne();
	      else{
	            if($mostrar=="") $retorn= $this->colectionNow->findOne($query);
	            else $retorn=$this->colectionNow->findOne($query, $mostrar);
	      } 
	      return $retorn;
	}
}

?>