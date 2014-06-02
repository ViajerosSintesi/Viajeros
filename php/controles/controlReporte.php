<?php


require_once("../clases/ReporteClass.php");
if(filter_has_var(INPUT_GET, "reportarImg")){
      require_once("../clases/ImagenClass.php");
      
      $report = new Report("reporteImg");
      
      $imgId = filter_input(INPUT_GET, "imgId");
      $userId = filter_input(INPUT_GET, "userId");
      
      $report->setUser($userId);
      $report->setObjectToReport($imgId);
      
      $report->reportarObjeto();
      
      if($report->contarReportes() >= 10 ){
            $report->eliminarPorReporte();
            $imagen = new Imagen();
            $imagen->setId($imgId);
            $imagen->cogeValoresSegunId();
            $imagen->borrarImagen();
      }
       echo json_encode(1);
}

if(filter_has_var(INPUT_GET, "reportarComent")){
      require_once("../clases/CommentClass.php");
      $tipo = filter_input(INPUT_GET, "reportarComent");
      $report = new Report("reporteComent");
      
      $comentId = filter_input(INPUT_GET, "comentId");
      $userId = filter_input(INPUT_GET, "userId");
      
      $report->setUser($userId);
      $report->setObjectToReport($comentId);
      
      $report->reportarObjeto();
      
      if($report->contarReportes() >= 10 ){
            $report->eliminarPorReporte();
            $coment = new Comment("coment".$tipo);
            $coment->setId($comentId);
            $coment->cogeValoresSegunId();
            $coment->borrarComent();
      }
      echo json_encode(1);
}
?>