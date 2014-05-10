<?php

/**
* 
*/
class User{
	
	private $nombre;
	private $apellidos;
	private $mail;

	function __construct($nombre, $apellidos, $mail){
		
		$this->nombre = $nombre;
		$this->apellidos = $apellidos;
		$this->mail = $mail;

	}
	public function setNombre($nombre) { $this->nombre = $nombre; }
	public function getNombre() { return $this->nombre; }
	public function setApellidos($apellidos) { $this->apellidos = $apellidos; }
	public function getApellidos() { return $this->apellidos; }
	public function setMail($mail) { $this->mail = $mail; }
	public function getMail() { return $this->mail; }

	public function guardarUser(){
			
	}
}
?>