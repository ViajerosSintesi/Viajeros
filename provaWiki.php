<?php

$json = file_get_contents('http://es.wikipedia.org/w/api.php?format=php&action=query&titles=India&prop=revisions&rvprop=content');

echo $json;

?>