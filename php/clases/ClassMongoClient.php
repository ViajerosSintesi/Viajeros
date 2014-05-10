<?php

/**
* 
*/
class DBMongo{
	private $dbUser = "txemens";
	private $dbPass = "h0lita";
	private $server = "mongodb://$dbUser:$dbPass@ds043329.mongolab.com:43329/viajeros";
	private $conexion;
	private $db = "viajeros";
	private $colectionNow;
	
	function __construct(){
		$this->conexion = new MongoClient();

	}

	public function conectar(){
		return $this->conexion;
	}

	public function selectCollection($colection){
		$database = $this->conexion->$this->db;
		$col = $database->$colection;
		$this->colectionNow = $col;
		return $col;
	}

	public function insertar($doc){
		$this->colectionNow->insert($doc);
	}

	public function findCollection($query){
		$cursor = $this->collectionNow->find($query);
		return $cursor;
	}

}

?>