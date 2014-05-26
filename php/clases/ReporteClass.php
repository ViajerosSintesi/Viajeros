
<?php
      require_once("ClassMongoClient.php");
	/**
	* 
	*/
	class report{
		
		private $user = null;
		private $objectToReport = null;
		private $bbdd; 
		
		function __construct($bbdd){
		      $this->bbdd = new DBMongo($bbdd);
		}
      	
      	public function getUser(){return $this->user;}
            public function setUser($user){$this->user = $user;}
            public function getObjectToReport(){return $this->objectToReport;}
            public function setObjectToReport($objectToReport){$this->objectToReport = $objectToReport;}
            public function getBbdd(){return $this->bbdd;}
            public function setBbdd($bbdd){$this->bbdd = $bbdd;}
	}
?>