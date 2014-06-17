<?php
class Mensaje {
    private $receptor;
    private $texto;
    private $fecha;
    private $leido;
    

    public function getReceptor() {return $this->receptor;}
    public function setReceptor($receptor) {$this->receptor = $receptor;}
    public function getTexto() {return $this->texto;}
    public function setTexto($texto) {$this->texto = $texto;}
    public function getFecha() {return $this->fecha;}
    public function setFecha($fecha) {$this->fecha = $fecha;}
    public function getLeido() {return $this->leido;}
    public function setLeido($leido) {$this->leido = $leido;}
}

