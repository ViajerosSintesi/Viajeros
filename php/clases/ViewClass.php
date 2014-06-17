<?php

class View{
      $diccionario = null;
      $plantilla = null;
      
      public function setPlantilla($nomp){$this->plantilla = $nomp;}
	public function setDiccionario($nueDic){$this->diccionario = $nueDic;}
	
	public function crearCuerpo(){
		$cadena = $this->plantilla;
		foreach ($this->diccionario as $key => $value) {
			 $cadena = str_replace('['.$key.']',$value,$cadena);
		}
		#guarda como cuerpo la plantilla mas el diccionario
		$this->setCuerpo($cadena);
	}
}
?>