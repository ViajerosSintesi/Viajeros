<?php
	require_once("./clases/UserClass.php");
      session_start();
      if(filter_has_var(INPUT_POST, "mail") && filter_has_var(INPUT_POST, "pass") && filter_has_var(INPUT_POST, "login")){
            
            $user = new User();
            $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
		$password = filter_input(INPUT_POST, "pass",FILTER_SANITIZE_STRING);
		
		$user->setId($mail);
		$user->setPassword($password);
	
		if($notice = $user->comproveLogin()){
		      $user->cogeValoresSegunId();
		      $_SESSION['userId'] = $user->getId();
		     
		}
		echo json_encode(array( "notice"=>$notice));
      }
      
      if(filter_has_var(INPUT_POST, "destroySession")){
            session_destroy();
            //cambiar al nuevo servidor!
            header("location:https://viajeros-c9-txemens.c9.io");
      }
?>