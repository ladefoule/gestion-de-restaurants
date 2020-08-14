<?php

require 'vendor/autoload.php';
require 'config.php';
require 'Resto.php';

$Parsedown = new Parsedown();
$Parsedown->setMarkupEscaped(true);

$url = $_GET['url'];
$url = explode('/', $url);

$route = $url[0];

$nom = $tel = $presentation = $tarif_min = $tarif_max = $site = $longitude = $latitude = '';

$routes = ['fiche', 'ajout', 'edit', 'delete', 'liste'];
$action = in_array($route, $routes) ? $route : 'Erreur';

switch ($action) {
   case 'fiche':
      if (isset($url[1])) {
         $id = $url[1];
         $resto = new Resto();
         $result = $resto->fiche($id);

         ob_start();
         require 'fiche.php';
         $contenu = ob_get_clean();
      }
      break;
   
   case 'liste':
      if(isset($url[1]) && isset($url[2])){
         $orderby = $url[1];
         $sens = $url[2];
         $sens = ($sens == 'asc') ? -1 : 1;

         $filter  = [];
         $options = ['sort' => [$orderby => $sens]];
         $restos = $restos->find($filter, $options);
      }
      else
         $restos = $restos->find();

      ob_start();
      require 'liste.php';
      $contenu = ob_get_clean();
      break;

   case 'delete':
      // SUPPRESSION DE RESTO
      if (isset($url[1])) {
         $id = $url[1];
         $_id = new MongoDB\BSON\ObjectId($id);
         $restos->deleteOne(
            ['_id' => $_id]
         );
      }
      ob_start();
      require 'liste.php';
      $contenu = ob_get_clean();
      break;

   case 'ajout':
      if(!isset($_POST['nom'])){
         ob_start();
         require 'form.php';
         $contenu = ob_get_clean();
      }else {
         $nom = $_POST['nom'];
         $tel = $_POST['tel'];
         $site = $_POST['site'];
         $presentation = $_POST['presentation'];
         $tarif_min = $_POST['tarif_min'];
         $tarif_max = $_POST['tarif_max'];
      
         $resto = [
            'nom' => $nom,
            'tel' => $tel,
            'site' => $site,
            'presentation' => $presentation,
            'tarif_min' => $tarif_min,
            'tarif_max' => $tarif_max
         ];
      
         $restos->insertOne($resto);
         ob_start();
         require 'liste.php';
         $contenu = ob_get_clean();
      }
      break;
   
   case 'edit':
      if (isset($url[1]))
      {
         $id = $url[1];
         $_id = new MongoDB\BSON\ObjectId($id);
         $result = $restos->find(['_id' => $_id]);
         if(!isset($_POST['nom'])){
            

            ob_start();
            require 'form.php';
            $contenu = ob_get_clean();
         }else{
            $nom = $_POST['nom'];
            $tel = $_POST['tel'];
            $site = $_POST['site'];
            $presentation = $_POST['presentation'];
            $tarif_min = $_POST['tarif_min'];
            $tarif_max = $_POST['tarif_max'];
         
            $resto = [
               'nom' => $nom,
               'tel' => $tel,
               'site' => $site,
               'presentation' => $presentation,
               'tarif_min' => $tarif_min,
               'tarif_max' => $tarif_max
            ];
         
            $restos->updateOne(['_id' => $_id], ['$set' => $resto]);
            ob_start();
            require 'liste.php';
            $contenu = ob_get_clean();
         }
      }
      break;
         
   default:
      # code...
      break;
}

require 'layout.php';


