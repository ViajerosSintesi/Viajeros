<?php

require_once("./clases/ReporteClass.php");
if(filter_has_var(INPUT_POST, "reportarImg")){
      require_once("clases/ImagenClass.php");
      
      $reportImg = new Reporte("reporteImg");
      
      $imgId = filter_input(INPUT_POST, "imgId");
      $userId = filter_input(INPUT_POST, "userId");
      
      $reportImg->setUser($userId);
      $reportImg->setObjectToReport($imgId);
      
}

?>