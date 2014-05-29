<?php

/**
* 
*/
class Pais{
	private $id = null;
	private $pais = null;
	private $info = null;
	private $coordenadas = null;
      private $bbdd;
      private $paisArray;
      
	public function getId(){return $this->id;}
	public function setId($id){$this->id = new MongoId($id);}
	public function getPais(){return $this->pais;}
	public function setPais($pais){$this->pais = $pais;}
	public function getInfo(){return $this->info;}
	public function setInfo($info){$this->info = $info;}
	public function getCoordenadas(){return $this->coordenadas;}
	public function setCoordenadas($coordenadas){$this->coordenadas = $coordenadas;}


      function __construct(){
           $this->bbdd = new DBMongo("ciudades");
      }
      
      public function paisToArray(){
            $this->paisArray = array(
                        "_id"             => $this->id,
                        "pais"            => $this->pais,
                        "info"            => $this->info,
                        "coordenadas"     => $this->coordenadad
                  );
      }
      public function listarCiudadesPais(){
            $arrayForFind = array("idPais"=>$this->id);
            $mongo= new DBMongo("ciudad");
            $ciudadesDelPais = $mongo->findCollection($arrayForFind);
            return $ciudadesDelPais;
      }
      public function cogerValorePorId(){
      
      }
}

?>