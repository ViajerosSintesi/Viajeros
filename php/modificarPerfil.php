<?php
require_once("./clases/UserClass.php");
session_start();

if(filter_has_var(INPUT_POST, "modPerfil") && isset($_SESSION["userId"])){
      
      $userId = $_SESSION["userId"];
      $user = new User();
      $user->setId($userId);
      $user->cogeValoresSegunId();
      
      if(filter_has_var(INPUT_POST, "username")){
            $username = filter_input(INPUT_POST, "username");
            $user->setUsername($username);
      }
      if(filter_has_var(INPUT_POST, "apellidos")){
            $apellidos = filter_input(INPUT_POST, "apellidos");
            $user->setApellidos($apellidos);
      }
      if(filter_has_var(INPUT_POST, "pass")){
            $pass = filter_input(INPUT_POST, "pass");
            $user->setPassword($pass);
      }
      if(filter_has_var(INPUT_POST, "edad")){
            $edad = filter_input(INPUT_POST, "edad");
            $user->setUsername($edad);
      }
     
      $returnUpd = $user->updateUser();
      echo json_encode(array( "notice"=>$returnUpd));
}
   
 if(isset($_FILES["imgPerfil"])){
            $userId = $_SESSION["userId"];
            $user = new User();
            $user->setId($userId);
            echo $user->ponerImgPerfil($_FILES["imgPerfil"]);
            /*
            $uploaddir = '../images/fotosPerfil/';
            $uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
            
            if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
                $user->setImgPerfil($uploadfile);
            }
            */
      }
?>