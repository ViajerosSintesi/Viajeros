
<?php
      require_once("ClassMongoClient.php");
	/**
	* clase report
	*/
	class Report{
		
		private $user = null;				#usuario que ha reportado
		private $objectToReport = null;		#objeto a reportar
		private $bbdd;				      #bbdd donde se guardan los reportes
		private $arrayReport;				#formato array del reporte
		
		/**
		 * [__construct description]
		 * al construirse solamente se conecta a la BBDD
		 * @param string $bbdd 		nombre de la bbdd
		 */
		function __construct($bbdd){
		      $this->bbdd = new DBMongo($bbdd);
		}
      	/**
      	 * getters and setters
      	 */
      	public function getUser(){return $this->user;}
        public function setUser($user){$this->user = $user;}
        public function getObjectToReport(){return $this->objectToReport;}
        public function setObjectToReport($objectToReport){$this->objectToReport = $objectToReport;}
        
        /**
         * [reportToArray description]
         * transforma las propiedades a formato array
         * los guarda en $this->arrayReport
         * @return [type] [description]
         */
        public function reportToArray(){
              $this->arrayReport = array(
                    'user'=> $this->user, 
                    "object"=>$this->objectToReport
                    );
        }
        /**
         * [comproveReportUser description]
         * comprueva que en la bbdd ya exista el mismo documento
         * @return int 		numero de veces encontradas el documento  
         */	
        public function comproveReportUser(){
              $this->reportToArray();
              return $this->bbdd->contar($this->arrayReport);
        }
        /**
         * [contarReportes description]
         *
         * cuenta los reportes que tiene un objecto
         * 
         * @return int 		numero de reportes del objeto
         */
        public function contarReportes(){
              $queryForCount = array('object' => $this->objectToReport);
              return $this->bbdd->contar($queryForCount);
        }

        /**
         * [reportarObjeto description]
         *
         * guarda en la BBDD si no existe, el reporte
         * @return [type] [description]
         */
        public function reportarObjeto(){
              $retorn = 0;
              if(!$this->comproveReportUser()){
                 $retorn = $this->bbdd->insertar($this->arrayReport);  
              }
              return $retorn;
        }

        /**
         * [eliminarPorReporte description]
         *
         * elimina el reporte de la BBDD
         */
        public function eliminarPorReporte(){
              $this->reportToArray();
              $this->bbdd->eliminar($this->arrayReport);
        }
	}
?>