<?php
	require_once("./clases/UserClass.php");
      session_start();
      if(filter_has_var(INPUT_POST, "mail") && filter_has_var(INPUT_POST, "pass") && filter_has_var(INPUT_POST, "login")){
            
            $user = new User();
            $mail = filter_input(INPUT_POST, "mail");
		$password = filter_input(INPUT_POST, "pass");
		
		$user->setId($mail);
		$user->setPassword($password);
		
		if($user->comproveLogin()){
		      $user->cogeValoresSegunId();
		      $_SESSION['user'] = $user;
		      echo "hola ".$user->getUsername();
		}
		
      }
?>