<?php
require_once("../clases/UserClass.php");
session_start();

/**
 * 
 * importantes:
 * modperfil: llamada a la funcion
 * userId: id del usuario
 * 
 * se recogen los datos enviados y actualiza los datos de la BBDD con los obtenidos
 * 
 * */
if(filter_has_var(INPUT_POST, "modPerfil") && isset($_SESSION["userId"])){
      
      $userId = $_SESSION["userId"];
      $user = new User();
      $user->setId(base64_decode($userId));
      $user->cogeValoresSegunId();
      
      if(filter_has_var(INPUT_POST, "username")){
            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
            $user->setUsername($username);
      }
      if(filter_has_var(INPUT_POST, "apellidos")){
            $apellidos = filter_input(INPUT_POST, "apellidos", FILTER_SANITIZE_STRING);
            $user->setApellidos($apellidos);
      }
      if(filter_has_var(INPUT_POST, "password")){
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);
            if($password!="")
                  $user->setPassword($password);
      }
      if(filter_has_var(INPUT_POST, "edad")){
            $edad = filter_input(INPUT_POST, "edad");
            $user->setUsername($edad);
      }
      if(filter_has_var(INPUT_POST, "privacidad")){
            $privacidad = filter_input(INPUT_POST, "privacidad");
            $user->setPrivado($privacidad);
      }
      if(filter_has_var(INPUT_POST, "email")){
            
            $id = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            
            if($id != base64_decode($userId)&&$id != ""){
                  $user->setId($id);
                  $user->setActivado(0);
                  $user->enviaEmailConfirm();
                  $returnUpd = $user->updateUser($userId);
                  
            }else{
                  $returnUpd = $user->updateUser();
            }
            
      }else{
            $returnUpd = $user->updateUser();
      }
     
      echo json_encode(array( "notice"=>$returnUpd));
}
/**
 * si recibe un fichero imagen, actualizará la foto de perfil
 * del usuario guardado en sesion
 * 
 * */ 
if(isset($_FILES["imgPerfil"])){
            $userId = $_SESSION["userId"];
            $user = new User();
            $user->setId(base64_decode($userId));
            echo $user->ponerImgPerfil($_FILES["imgPerfil"]);
}
?>