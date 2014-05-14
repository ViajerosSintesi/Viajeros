<?php
	require_once("./clases/UserClass.php");
      session_start();
      if(filter_has_var(INPUT_POST, "mail") && filter_has_var(INPUT_POST, "pass") && filter_has_var(INPUT_POST, "login")){
            
            $user = new User();
            $mail = filter_input(INPUT_POST, "mail");
		$password = filter_input(INPUT_POST, "pass");
		
		$user->setId($mail);
		$user->setPassword($password);
		
		if($notice = $user->comproveLogin()){
		      $user->cogeValoresSegunId();
		      $_SESSION['userId'] = $user->getId();
		     
		}
		echo json_encode(array( "notice"=>$notice));
      }
?>