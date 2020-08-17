<?php

$mongo = new MongoDB\Client("mongodb://127.0.0.1:27017");
$db = $mongo->restaurants;
$restos = $db->restos;

const SITE = 'http://192.168.1.48/gestion-de-restaurants/';

const ID_NON_RENSEIGNE = "Merci de renseigner l'ID du resto !";

const ID_INCORRECT = "Impossible de convertir l'ID en ObjectId";

const RESTO_INCONNU = "Resto introuvable !";