<?php
require_once("../clases/MensajeClass.php");

if(filter_has_var(INPUT_GET,"user")&&filter_has_var(INPUT_GET,"verMnsjRec")){
      require_once("../clases/UserClass.php");
      $user = filter_input(INPUT_GET,"user");
      $mensajeC = new Mensaje();
      $mensajeC->setReceptor($user);
      $mensajes = $mensajeC->verMnsjReceptor();
      
      for($i = 0;$i< count($mensajes); $i++){
            $userR = new User();
            $userR->setId(base64_decode($mensajes[$i]["remitente"]));
            $userR->cogeValoresSegunId();
            
            $mensajes[$i]["nomRemitente"] = $userR->getUsername();
      }
      
      echo json_encode($mensajes);
}
if(filter_has_var(INPUT_GET,"userReceptor")&&filter_has_var(INPUT_GET,"enviarMnsj")){
      session_start();
      if(isset($_SESSION["userId"])){
            $userRem = $_SESSION["userId"];
            $userRec = filter_input(INPUT_GET,"userReceptor");
            $texto = filter_input(INPUT_GET,"texto");
            $fecha = filter_input(INPUT_GET,"fecha");
            $mensajeC = new Mensaje();
            $mensajeC->setReceptor($userRec);
            $mensajeC->setRemitente($userRem);
            $mensajeC->setTexto($texto);
            $mensajeC->setFecha($fecha);
            
            echo json_encode($mensajeC->guardarMensj());
      }else
            echo json_encode(0);
}
?>