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

/*
switch ($action) {
   // FICHE D'UN RESTO
   case 'fiche':
      if (isset($url[1])) {
         $id = $url[1];
         $resultatRequete = $restos->fiche($id);

         ob_start();
         require 'fiche.php';
         $contenu = ob_get_clean();
      }
      break;

   // LISTE DE TOUS LES RESTOS
   case 'liste':
      if(isset($url[1]) && isset($url[2])){
         $orderby = $url[1];
         $sens = $url[2];
         $sens = ($sens == 'asc') ? -1 : 1;

         $resultatRequete = $restos->liste($orderby, $sens);
      }else
         $resultatRequete = $restos->liste();

      ob_start();
      require 'liste.php';
      $contenu = ob_get_clean();
      break;

   // SUPPRESSION DE RESTO
   case 'delete':
      if (isset($url[1])) {
         $id = $url[1];
         $restos->delete($id);
      }

      $resultatRequete = $restos->liste();
      ob_start();
      require 'liste.php';
      $contenu = ob_get_clean();
      break;

   // AJOUT D'UN RESTO
   case 'ajout':
      $resultatRequete = [];
      // Si on accède pour la 1ère fois à la page d'ajout (formulaire)
      if(!isset($_POST['nom'])){
         ob_start();
         require 'form.php';
         $contenu = ob_get_clean();

      // Si on reçoit des infos venant du formulaire (POST)
      }else {
         $resto = verifInputs($_POST, $fillable);
         // Si la validation ne passe pas, on renvoie un message d'erreur
         if($resto == false){
            ob_start(); 
            echo '<div class="alert alert-danger" role="alert"> Echec de l\'ajout </div>';
            $contenu = ob_get_clean();
            break;
         }
      
         $restos->ajout($resto);
         $resultatRequete = $restos->liste();
         ob_start();
         require 'liste.php';
         $contenu = ob_get_clean();
      }
      break;

   // MAJ DES INFOS D'UN RESTO
   case 'edit':
      if (isset($url[1]))
      {
         $id = $url[1];
         $resultatRequete = $restos->fiche($id);

         // On accède pour la 1ère fois à la page edit
         if(!isset($_POST['nom'])){
            ob_start();
            require 'form.php';
            $contenu = ob_get_clean();

         // Validation du formulaire depuis la page edit
         }else{
            $resto = verifInputs($_POST, $fillable);

            // Si la validation ne passe pas, on renvoie un message d'erreur
            if($resto == false){
               ob_start(); 
               echo '<div class="alert alert-danger" role="alert"> Echec de la mise à jour. </div>';
               $contenu = ob_get_clean();
               break;
            }
         
            $restos->edit($id, $resto);
            $resultatRequete = $restos->liste();
            ob_start();
            require 'liste.php';
            $contenu = ob_get_clean();
         }
      }
      break;
         
   default:
      ob_start();
      echo "Vous n'avez pas accès à cette page.";
      $contenu = ob_get_clean();
      break;
}*/


