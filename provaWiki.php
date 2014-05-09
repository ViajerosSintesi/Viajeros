<?php

$con = new MongoClient("mongodb://txemens:h0lita@ds043329.mongolab.com:43329/viajeros");
var_dump($con);
/*
$json = file_get_contents('http://es.wikipedia.org/w/api.php?format=php&action=query&titles=India&prop=revisions&rvprop=content');

echo $json;
*/

?>