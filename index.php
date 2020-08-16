<?php

require_once 'htmlpurifier/library/HTMLPurifier.auto.php';
require_once 'vendor/autoload.php';
require_once 'config.php';
require_once 'fonctions.php';

$Parsedown = new Parsedown();
$Parsedown->setMarkupEscaped(true);
$purifier = new HTMLPurifier();

if(isset($_GET['url']) == false)
   $_GET['url'] = 'liste';

$url = $_GET['url'];
$url = explode('/', $url);
$route = $url[0];

$controller = 'ErreurController';
$action = 'erreur404';

$routes = ['fiche', 'ajout', 'edit', 'delete', 'liste'];
if(in_array($route, $routes)){
   $controller = 'RestoController';
   $action = $route;
}

$routes = ['editadresse'];
if(in_array($route, $routes)){
   $controller = 'AdresseController';
   $action = $route;
}

$restos = new Restos();

ob_start();
$controller::$action(['restos' => $restos, 'requetePOST' => $_POST, 'requeteGET' => $_GET['url']]);
$contenu = ob_get_clean();

require './vues/layout.php';
