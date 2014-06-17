<?php
require_once("../clases/MensajeClass.php");

if(filter_has_var(INPUT_GET,"user")&&filter_has_var(INPUT_GET,"verMnsjRec")){
      
      $user = filter_input(INPUT_GET,"user");
      $mensajeC = new Mensaje();
      $mensajeC->setReceptor($user);
      
      echo json_encode($mensajeC->verMnsjReceptor());
}
if(filter_has_var(INPUT_GET,"userRemitente")&&filter_has_var(INPUT_GET,"enviarMnsj")){
      
      $userRem = filter_input(INPUT_GET,"userRemitente");
      $userRec = filter_input(INPUT_GET,"userReceptor");
      $texto = filter_input(INPUT_GET,"texto");
      $fecha = filter_input(INPUT_GET,"fecha");
      $mensajeC = new Mensaje();
      $mensajeC->setReceptor($userRec);
      $mensajeC->setRemitente($userRem);
      $mensajeC->setTexto($texto);
      $mensajeC->setFecha($fecha);
      
      echo json_encode($mensajeC->guardarMensj());
}
?>