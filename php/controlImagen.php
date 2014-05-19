<?php
      require_once("clases/ImagenClass.php");
      require_once("clases/UserClass.php");
      require_once("clases/CiudadClass.php");
      
      if ($_FILES["picture"]["error"] > 0) {
      echo "Error: " . $_FILES["picture"]["error"] . "<br>";
      } 
      if(isset($_FILES["picture"])){
            
            
            $userId= filter_input(INPUT_POST, "userId");
            $ciudadId= filter_input(INPUT_POST, "ciudadId");
            
            $imagenForUp = $_FILES["picture"];
            $imagen = new Imagen();
            
            $imagen->setNombre($imagenForUp["name"]);
            $imagen->setCiudad($ciudadId);
            $imagen->setUsuario($userId);
            $imagen->setRuta();
            
            $imagen->subirImagen($imagenForUp);
            echo $imagen->guardarImagen();
      
      }

?>