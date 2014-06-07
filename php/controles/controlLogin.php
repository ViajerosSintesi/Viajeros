<?php
	require_once("../clases/UserClass.php");
      session_start();
      if(filter_has_var(INPUT_POST, "mail") && filter_has_var(INPUT_POST, "pass") && filter_has_var(INPUT_POST, "login")){
            
            $user = new User();
            $mail = filter_input(INPUT_POST, "mail", FILTER_SANITIZE_EMAIL);
		$password = filter_input(INPUT_POST, "pass",FILTER_SANITIZE_STRING);
	
		
		$user->setId($mail);
		$user->setPassword($password);
		$pasa = 0;

	      if(isset($_SESSION['captcha'])){
	            $code = filter_input(INPUT_POST, "code",FILTER_SANITIZE_STRING);
	            if($code == $_SESSION['captcha']){
	                   session_destroy();
	                   $pasa =1;
	                   
	           }else{
	                 session_destroy();
	           }
	      }else $pasa = 1;
	      
	      $notice =0;

	      if($pasa){
      		if( $notice =$user->comproveLogin()){
      		      $user->cogeValoresSegunId();
      		      $_SESSION['userId'] = $user->getId();
      		      //echo $notice;
      		}else{
      		      echo $notice;
      		     if(filter_has_var(INPUT_COOKIE,"login")){
                              $numIntentos = filter_input(INPUT_COOKIE,"login");
                              if($numIntentos <4){
                                    $expire=time()+60*4;
                                    setcookie("login", $numIntentos+1, $expire);
                              
                              }else $notice ="3";
                              
                        }else{
                              $expire=time()+60*4;
                               setcookie("login", 0, $expire);
                        }
      		      
      		}
	      }
	      
		echo json_encode(array( "notice"=>$notice));
      }
      
      if(filter_has_var(INPUT_POST, "destroySession")){
            session_destroy();
            //cambiar al nuevo servidor!
            header("location:http://viajeros.herokuapp.com");
      }
?>