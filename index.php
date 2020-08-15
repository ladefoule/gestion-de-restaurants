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

$routes = ['fiche', 'ajout', 'edit', 'editadresse', 'delete', 'liste'];
$action = in_array($route, $routes) ? $route : 'erreur404';

$restos = new Restos();

ob_start();
Controller::$action(['restos' => $restos, 'requetePOST' => $_POST, 'requeteGET' => $_GET['url']]);
$contenu = ob_get_clean();

require './vues/layout.php';
