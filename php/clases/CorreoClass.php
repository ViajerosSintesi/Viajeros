<?php

//Clase correo 
class Correo {
	# propiedades 
	private $destinatario;
	private $asunto;
	private $cuerpo;

	# headers
	private $headersMIME;
	private $headersContentType;
	private $headersFrom;
	private $headersReplyTo;
	private $headersReturnPath;
	private $headersCC;
	private $headersBCC;

	private $headersTotal;
	
	private $plantilla;//plantilla html
	private $diccionario = array();//palabras a cambiar en plantilla
/**
 * Constructor de clase
 * 
 * @param array $diccionario       	Palabras para cambiar en la plantilla
 * @param file $plantilla         	ruta del archivo
 * @param string $destinatario      mail del destino
 * @param string $asunto            asunto del mail
 * @param string $mensaje           mensaje
 * @param string $from              desde donde se envia
 * @param string $headersMIME       
 * @param string $headersReplyTo    
 * @param string $headersReturnPath 
 * @param string $headersCC        	
 * @param string $headersBCC        
 */
	function __construct($diccionario, $plantilla,
		$destinatario, $asunto, $from,
						$headersMIME = "1.0",
						$headersReplyTo = " ",
						$headersReturnPath = " ",
						$headersCC = " ",
						$headersBCC = " "){

	$headersContentType = "text/html; charset=iso-8859-1";
	$this->diccionario = $diccionario;
	//se llama al setPlantilla ya que recoge de una ruta el fichero
	$this->setPlantilla($plantilla);
		$this->destinatario = $destinatario;
		$this->asunto = $asunto;
	

		# Headers
		$this->headersFrom = $from;
		$this->headersContentType = $headersContentType;
		$this->headersMIME = $headersMIME;
		$this->headersReplyTo = $headersReplyTo;
		$this->headersReturnPath = $headersReturnPath;
		$this->headersCC = $headersCC;
		$this->headersBCC = $headersBCC;

	}
/**
 * inicializar plantilla a partir de una ruta
 * 
 * @param string $nomp nombre de la plantilla para cargarla en variable 
 */
	public function setPlantilla($nomp){
		$this->plantilla = $nomp;

	}
	public function setDiccionario($nueDic){
		$this->diccionario = $nueDic;
	}
	/**
	 * Crea el cuerpo, juntando la platilla con el diccionario
	 * e intercambiando los valores en sus posiciones
	 * 
	 */
	public function crearCuerpo(){
		$cadena = $this->plantilla;
		foreach ($this->diccionario as $key => $value) {
			 $cadena = str_replace('['.$key.']',$value,$cadena);
		}
		#guarda como cuerpo la plantilla mas el diccionario
		$this->setCuerpo($cadena);
	}
/**
	 * reacreacion para enviar el mail, ya que solo lo muestra
	 * La funcion que envia esta comentada por que no tenemos un servidor de correo
	 *
	 * ->los echos solamente son orientativos, en caso real no tendrian que existir,
	 * ->Solamente son para recrear el funcionamiento y demostrar que llega a este punto
	 */
	public function enviarMail(){
	      $this->crearCuerpo();
            $this->constHeaders();
            require_once('class.phpmailer.php');
            require_once('class.smtp.php');
            require 'PHPMailerAutoload.php';
            $mail = new PHPMailer();
            
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->Port = 25;
            $mail->Host = 'smtp.sendgrid.net';
            $mail->Username = $_ENV["SENDGRID_USERNAME"];
            $mail->Password = $_ENV["SENDGRID_PASSWORD"];
            
            $mail->AddReplyTo($this->headersFrom, "Paradise");
            $mail->SetFrom($this->headersFrom, "Paradise");    
            $mail->AddAddress($this->destinatario, "Dermatologico del Norte");
            $mail->Subject = $this->asunto;
            $mail->MsgHTML($this->cuerpo);
            
            if(!$mail->Send()) echo "Mailer Error: " . $mail->ErrorInfo;
            
      /*
      #crear cabezera
		$this->constHeaders();
		#si no estan construidas las cabezeras mostrara un mensaje de error
		if(!$this->headersTotal){
			echo "Caxo error, no estan los headers contruidos, la funcion para contruir es constHeaders()";
		}else{
			mail($this->destinatario, $this->asunto, $this->cuerpo, $this->headersTotal);
			// $this->headersTotal;
			//echo $this->cuerpo;
		}
*/
	}
	
	#gets y sets de cada campo
	public function getDestinatario(){
		return $this->destinatario;
	}

	public function setDestinatario($destinatario){
		$this->destinatario = $destinatario;
	}

	public function getAsunto(){
		return $this->asunto;
	}

	public function setAsunto($asunto){
		$this->asunto = $asunto;
	}

	public function getCuerpo(){
		return $this->cuerpo;
	}

	public function setCuerpo($cuerpo){
		$this->cuerpo = $cuerpo;
	}

	public function getHeadersMIME(){
		return $this->headersMIME;
	}

	public function setHeadersMIME($headersMIME){
		$this->headersMIME = $headersMIME;
	}

	public function getHeadersContentType(){
		return $this->headersContentType;
	}

	public function setHeadersContentType($headersContentType){
		$this->headersContentType = $headersContentType;
	}

	public function getHeadersFrom(){
		return $this->headersFrom;
	}

	public function setHeadersFrom($headersFrom){
		$this->headersFrom = $headersFrom;
	}

	public function getHeadersReplyTo(){
		return $this->headersReplyTo;
	}

	public function setHeadersReplyTo($headersReplyTo){
		$this->headersReplyTo = $headersReplyTo;
	}

	public function getHeadersReturnPath(){
		return $this->headersReturnPath;
	}

	public function setHeadersReturnPath($headersReturnPath){
		$this->headersReturnPath = $headersReturnPath;
	}

	public function getHeadersCC(){
		return $this->headersCC;
	}

	public function setHeadersCC($headersCC){
		$this->headersCC = $headersCC;
	}

	public function getHeadersBCC(){
		return $this->headersBCC;
	}

	public function setHeadersBCC($headersBCC){
		$this->headersBCC = $headersBCC;
	}

	public function getHeadersTotal(){
		return $this->headersTotal;
	}

	/**
	 * Funcion que recoge todas las propiedades que son parte de los headers
	 * para concatenarlo y crear la cabezera para enviar
	 * Los campos no necesarios se concatenaran si no estan vacios
	 *
	 * Se concatenarán para guardarlo en la propiedad headersTotal
	 */
	public function constHeaders(){
		$this->headersTotal = "MIME-Version: ".$this->headersMIME."\r\n";
		$this->headersTotal .= "Content-type: ".$this->headersContentType."\r\n";
		$this->headersTotal .= "From: ".$this->headersFrom."\r\n";
		
		if ($this->headersReplyTo != " ")
			$this->headersTotal .= "Reply-to: ".$this->headersReplyTo."\r\n";
		if ($this->headersReturnPath != " ")
			$this->headersTotal .= "Return-path: ".$this->headersReturnPath."\r\n";
		if ($this->headersCC != " ")
			$this->headersTotal .= "CC: ".$this->headersCC."\r\n";
		if ($this->headersBCC != " ")
			$this->headersTotal .= "BCC: ".$this->headersBCC."\r\n";

	}
}
	
?>