
<?php
      require_once("ClassMongoClient.php");
	/**
	* 
	*/
	class Report{
		
		private $user = null;
		private $objectToReport = null;
		private $bbdd;
		private $arrayReport;
		
		function __construct($bbdd){
		      $this->bbdd = new DBMongo($bbdd);
		}
      	
      	public function getUser(){return $this->user;}
            public function setUser($user){$this->user = $user;}
            public function getObjectToReport(){return $this->objectToReport;}
            public function setObjectToReport($objectToReport){$this->objectToReport = $objectToReport;}
            
            public function reportToArray(){
                  $this->arrayReport = array(
                        'user'=> $this->user, 
                        "object"=>$this->objectToReport
                        );
            }
            public function comproveReportUser(){
                  $this->reportToArray();
                  return $this->bbdd->contar($this->arrayReport);
            }
            public function contarReportes(){
                  $queryForCount = array('object' => $this->objectToReport);
                  return $this->bbdd->contar($queryForCount);
            }
            public function reportarObjeto(){
                  $retorn = 0;
                  if(!$this->comproveReportUser()){
                     $retorn = $this->bbdd->insertar($this->arrayReport);  
                  }
                  return $retorn;
            }
            public function eliminarPorReporte(){
                  $this->reportToArray();
                  $this->bbdd->eliminar($this->arrayReport);
            }
	}
?>