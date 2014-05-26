<?php
      require_once("clases/ImagenClass.php");
      require_once("clases/UserClass.php");
      require_once("clases/CiudadClass.php");
      session_start();
       
      if(isset($_FILES["picture"])){
            
            
            $userId= filter_input(INPUT_POST, "userId");
            $ciudadId= filter_input(INPUT_POST, "ciudadId");
            $ciudadId = explode(" ", $ciudadId);
            $ciudad = new Ciudad();
            $ciudad->setNombre($ciudadId[0]);
            $ciudad->setPais($ciudadId[2]);

            $ciudad->buscarCiudad("ciudad");
            
            $imagenForUp = $_FILES["picture"];
            $imagen = new Imagen();
            
            $imagen->setNombre($imagenForUp["name"]);
            $imagen->setCiudad($ciudad->getId());
            $imagen->setUsuario($userId);
            $imagen->setRuta();
            
            $imagen->subirImagen($imagenForUp);
            //echo $imagen->guardarImagen();
            header("location: ../perfil.php");
      
      }
      if(filter_has_var(INPUT_GET, "fotosForPerfil")){
            $userId= filter_input(INPUT_GET, "userId");
            
            $imagen = new Imagen();
            
            $imagen->setUsuario($userId);
            
            echo json_encode($imagen->darImagenes());
            
      }
      if(filter_has_var(INPUT_GET, "borrarImagen")){
            $imagenId = filter_input(INPUT_GET, "imagenId");
            
            $imagen = new Imagen();
            
            $imagen->setId(new MongoId($imagenId));
            
            $imagen->cogeValoresSegunId();

            echo json_encode($imagen->borrarImagen());
      }
?>