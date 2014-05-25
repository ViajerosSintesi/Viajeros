<?php

$con = new MongoClient("mongodb://txemens:h0lita@ds043329.mongolab.com:43329/viajeros");

$col = $con->viajeros->usuarios;

$doc = array("name" => "txema");
$col->insert($doc);

$document = $col->findOne();
var_dump( $document );
/*
$json = file_get_contents('http://es.wikipedia.org/w/api.php?format=php&action=query&titles=India&prop=revisions&rvprop=content');

echo $json;
*/

?>