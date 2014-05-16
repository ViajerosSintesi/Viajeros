<?php
/*
$con = new MongoClient("mongodb://txemens:h0lita@ds043329.mongolab.com:43329/viajeros");

$col = $con->viajeros->usuarios;

$doc = array("name" => "txema");
$col->insert($doc);

$document = $col->findOne();
var_dump( $document );
https://github.com/lahdekorpi/Wiky.php
*/
require_once("wiki.inc.php");
$wiky=new wiky;
$json = file_get_contents('http://en.wikipedia.org/w/api.php?format=json&action=query&titles=barcelona&prop=revisions&rvprop=content');
$json = json_decode($json);
echo "<pre>";



?>