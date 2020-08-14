<?php 

$mongo = new MongoDB\Client("mongodb://127.0.0.1:27017");
$db = $mongo->restaurants;
$restos = $db->restos;