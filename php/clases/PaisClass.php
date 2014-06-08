<?php

/**
* clase pais
* 
* 
*/
class Pais{
	private $id = null;                 #id del pais
	private $pais = null;               #nombre del pais
	private $info = null;               #informacion del pais
	private $coordenadas = null;        #coordenadas del pais
    private $bbdd;                      #BBDD que apunta a la coleccion
    private $paisArray;                 #datos en formato Array
      
  	/**
  	 * Getters And setters
  	 */
	public function getId(){return $this->id;}
	public function setId($id){$this->id = new MongoId($id);}
	public function getPais(){return $this->pais;}
	public function setPais($pais){$this->pais = $pais;}
	public function getInfo(){return $this->info;}
	public function setInfo($info){$this->info = $info;}
	public function getCoordenadas(){return $this->coordenadas;}
	public function setCoordenadas($coordenadas){$this->coordenadas = $coordenadas;}

	/**
	 * [__construct description]
	 *
	 * constructor por defecto
	 * Al iniciar se conecta con la BBDD de pais
	 */
    function __construct(){
        $this->bbdd = new DBMongo("pais");
    }
    
    /**
     * [paisToArray description]
     * introduce las propiedades del pais en formato array a las propiedad 
     * $this->paisArray
     */
    public function paisToArray(){
            $this->paisArray = array(
                        "_id"             => $this->id,
                        "pais"            => $this->pais,
                        "info"            => $this->info,
                        "coordenadas"     => $this->coordenadad
                  );
    }

    /**
     * [listarCiudadesPais description]
     * funcion que busca las ciudades del pais
     * @return Array[]		array con las ciudades que pertenecen al pais
     */
	public function listarCiudadesPais(){
	    $arrayForFind = array("idPais"=>$this->id);
	    $mongo= new DBMongo("ciudad");
	    $ciudadesDelPais = $mongo->findCollection($arrayForFind);
	    return $ciudadesDelPais;
	}
	/*public function cogerValorePorId(){

	}*/
}

?>