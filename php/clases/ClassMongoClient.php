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
		$this->colectionNow->insert($doc);
		return $this->findCollection($doc);
	}

	public function findCollection($query=""){
		$cursor = $this->collectionNow->find($query);
		return $cursor;
	}

	public function contar($query=""){
		return $this->colectionNow->count($query);
	}

	public function eliminar($query, $opt=""){
		$this->colectionNow->remove($query, $opt);
	}

	public function actualiza($query, $newData,$opt=""){
		$this->colectionNow->update($query, $newData, $opt);
	}

	public function getCollection(){
		return $this->colectionNow;
	}
}

?>