<?php

require_once 'htmlpurifier/library/HTMLPurifier.auto.php';
require_once 'vendor/autoload.php';
require_once 'config.php';
require_once 'fonctions.php';

$Parsedown = new Parsedown();
$Parsedown->setMarkupEscaped(true);
$purifier = new HTMLPurifier();

$url = $_GET['url'];
$url = explode('/', $url);

$route = $url[0];

$routes = ['fiche', 'ajout', 'edit', 'delete', 'liste'];
$action = in_array($route, $routes) ? $route : 'erreur404';

$restos = new Restos();
$fillable = $restos->getFillable();

ob_start();
Controller::$action(['restos' => $restos, 'fillable' => $fillable, 'requetePOST' => $_POST, 'requeteGET' => $_GET['url']]);
$contenu = ob_get_clean();

require './vues/layout.php';
