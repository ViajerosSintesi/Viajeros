<?php
      require_once("../clases/ImagenClass.php");
      require_once("../clases/UserClass.php");
      require_once("../clases/CiudadClass.php");
      require_once("../clases/ClassMongoClient.php");
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
            $imagen->setCiudad($ciudad->getNombre());
            $imagen->setPais($ciudad->getPais());
            $imagen->setUsuario($userId);
            $imagen->setRuta();
            
            $imagen->subirImagen($imagenForUp);
            //echo $userId;
            //echo $imagen->guardarImagen();
            header("location: ../../perfil.php");
      
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
      if(filter_has_var(INPUT_GET, "fotosForCiudad")){
            $ciudadId= filter_input(INPUT_GET, "ciudadId");
            $ciudad = new Ciudad();

            $ciudad->setId($ciudadId);
            $ciudad->cogeValoresSegunId();
            $imagen = new Imagen();
            
            $imagen->setCiudad($ciudad->getNombre());

            echo json_encode($imagen->darImagenes(false));
            
      }
      if(filter_has_var(INPUT_GET, "pais")){
            require_once("../clases/PaisClass.php");
            $paisId= filter_input(INPUT_GET, "pais");
            $pais = new Pais();
            $pais->setId($paisId);
            $ciudadesDelPais = $pais->listarCiudadesPais();
            //var_dump($ciudadesDelPais);
            for($i=0; $i<count($ciudadesDelPais);$i++){
                  $imagen = new Imagen();
                  $imagen->setCiudad($ciudadesDelPais[$i]["ciudad"]);
                  
                  echo json_encode($imagen->darImagenes(false));
            }
      }

?>