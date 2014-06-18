<?php
 require_once("ClassMongoClient.php");
class Mensaje {
    
    private $remitente;
    private $receptor;
    private $texto;
    private $fecha;
    private $leido;
    private $BBDD;
    private $mensajeArray;
    
    public function getRemitente() {return $this->remitente;}
    public function setRemitente($remitente) {$this->remitente = $remitente;}
    public function getReceptor() {return $this->receptor;}
    public function setReceptor($receptor) {$this->receptor = $receptor;}
    public function getTexto() {return $this->texto;}
    public function setTexto($texto) {$this->texto = $texto;}
    public function getFecha() {return $this->fecha;}
    public function setFecha($fecha) {$this->fecha = $fecha;}
    public function getLeido() {return $this->leido;}
    public function setLeido($leido) {$this->leido = $leido;}
    
    function __construct(){
          $this->bbdd = new DBMongo("mensajes");
    }
    public function mensjToArray(){
	    $this->mensajeArray = array(
	                      "remitente" => $this->remitente,
	                      "receptor" => $this->receptor,
	                      "texto" => $this->texto,
	                      "fecha" => $this->fecha,
	                      "leido" => $this->leido
	                );
	}
    public function guardarMensj(){
          $this->leido=0;
          $this->mensjToArray();
          
          return $this->bbdd->insertar($this->mensajeArray);
    }
    
    public function verMnsjReceptor(){
          	$query = array("receptor" =>$this->receptor);
          	return  $this->bbdd->findCollection($query);
    }
    
}

