<?php

/**
* clase Captcha
* @author 
*/
class Captcha{

	# Propiedades
	private $width; //anchura del captcha
	private $height; //altura del captcha
	private $numCaracters; //numero de caracteres
	private $image;
	private $backColor;
	#propiedades fuente
	private $font; //ruta de la fuente
	private $textColor;
	private $sizeFont;

	#propiedades ruido
	private $numDots;
	private $numLines;
	private $noiseColor; 
	
	private $code = "";

	#posiciones de la paleta de colores una vez aceptados
	private $posBackColor;
	private $posTextColor;
	private $posnoiseColor;
	/**
	 * Constructor de la clase captcha
	 * 
	 * @param int $width        anchura de la imagen
	 * @param int $height       altura de la imagen
	 * @param int $numCaracters numero de caracteres
	 */
	function __construct($width, $height, $numCaracters){
		$this->width = $width;
		$this->height = $height;
		$this->numCaracters = $numCaracters;
		# Segun la altura, el tamaño de la letra variara
		$this->sizeFont = $height * 0.50;
		# inicia la imagen
		$this->image = imagecreate($width, $height);
	}


	#Gets i sets de las propiedades
	public function getCode(){
		return $this->code;
	}
	public function getImage(){
		return $this->image;
	}
	public function getWidth(){
		return $this->width;
	}

	public function setWidth($width){
		$this->width = $width;
	}

	public function getHeight(){
		return $this->height;
	}

	public function setHeight($height){
		$this->height = $height;
	}

	public function getNumCaracters(){
		return $this->numCaracters;
	}

	public function setNumCaracters($numCaracters){
		$this->numCaracters = $numCaracters;
	}

	public function getFont(){
		return $this->font;
	}

	public function setFont($font){
		$this->font = $font;
	}

	public function getNumDots(){
		return $this->numDots;
	}

	public function setNumDots($numDots){
		$this->numDots = $numDots;
	}

	public function getNumLines(){
		return $this->numLines;
	}

	public function setNumLines($numLines){
		$this->numLines = $numLines;
	}
	
	public function getNoiseColor(){
		return $this->noiseColor;
	}

	public function setNoiseColor($red, $green, $blue){
		$this->noiseColor[0] = $red;
		$this->noiseColor[1] = $green;
		$this->noiseColor[2] = $blue;
	}
	public function getTextColor(){
		return $this->textColor;
	}

	public function setTextColor($red, $green, $blue){
		$this->textColor[0] = $red;
		$this->textColor[1] = $green;
		$this->textColor[2] = $blue;
	}
	public function getSizeFont(){
		return $this->sizeFont;
	}
	public function getBackColor(){
		return $this->backColor;
	}

	public function setBackColor($red, $green, $blue){
		$this->backColor[0] = $red;
		$this->backColor[1] = $green;
		$this->backColor[2] = $blue;
	}
	/**
	 * Crea un codigo que serà aleatorio
	 *
	 * Del codigo se han extraido letras que podrian ocasionar
	 * confusion
	 */
	public function crearCode(){
		$letras = '23456789bcdfghjkmnpqrstvwxyz';
		$i = 0;
		while ($i < $this->numCaracters) { 
			$this->code .= substr($letras, mt_rand(0, strlen($letras)-1), 1);
			$i++;
		}
	}
	/**
	 * recoge las funciones necesarias para construir la imagen
	 * @return [type] [description]
	 */
	public function creaCaptcha(){
		$this->crearCode(); #crea el codigo
		$this->aceptarColors(); #guarda colores en la paleta
		$this->createNoise(); #dibuja el ruido
		$this->createText(); #dibuja el texto
	}

	/**
	 * funcion que guarda los colores en la paleta de la imagen
	 */
	public function aceptarColors(){
		#color del background
		$this->posBackColor = imagecolorallocate(
				$this->image,
				$this->backColor[0],
				$this->backColor[1],
				$this->backColor[2]
			);
		$this->posTextColor = imagecolorallocate(
				$this->image,
				$this->textColor[0],
				$this->textColor[1],
				$this->textColor[2]
			);
		$this->posNoiseColor = imagecolorallocate(
				$this->image,
				$this->noiseColor[0],
				$this->noiseColor[1],
				$this->noiseColor[2]
			);
	}
	/**
	 * funciona para crear puntos y lineas apartir de 
	 * los colores guardados en la paleta y el numero
	 * de lineas y puntos
	 *
	 */
	public function createNoise(){
		#generar puntos
		for( $i=0; $i<$this->numDots; $i++ ) {
			imagefilledellipse($this->image, mt_rand(0,$this->width),
				mt_rand(0,$this->height), 2, 3, $this->posNoiseColor);
		}
		#generar lineas
		for( $i=0; $i<$this->numLines; $i++ ) {
			imageline($this->image, mt_rand(0,$this->width), mt_rand(0,$this->height),
				 mt_rand(0,$this->width), mt_rand(0,$this->height), $this->posNoiseColor);
		}
	}
	/**
	 * Funcion para crear el texto y dibujarlo en la imagen
	 * 
	 */
	public function createText(){
		$textbox = imagettfbbox($this->sizeFont, 0, $this->font, $this->code); 
		$x = ($this->width - $textbox[4])/2;
		$y = ($this->height - $textbox[5])/2;
		imagettftext($this->image, $this->sizeFont, 0, $x, $y, $this->posTextColor, $this->font, $this->code);
	}
	/**
	 * Funcion para crear del todo i retornarla
	 * @param  string $file si le pasamos un nombre, creara el fichero
	 * 
	 */
	public function returnImage($file = ""){
		if($file == ""){
			try{
				header('Content-Type: image/jpeg');
				imagejpeg($this->image);
			}catch(Exception $e){
				echo $e->getMessage();
			}
			
		}else{
			imagejpeg($this->image, $file);
		}
	}

}



?>