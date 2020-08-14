<?php 

$mongo = new MongoDB\Client("mongodb://127.0.0.1:27017");
$db = $mongo->restaurants;
$restos = $db->restos;

const SITE = 'http://192.168.1.48/php/semaine-10/jeudi/resto/';