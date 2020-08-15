<?php

class Controller
{
   public function fiche()
   {
      $restos = new Restos();

      if (isset($url[1])) {
         $id = $url[1];
         $resultatRequete = $restos->fiche($id);

         ob_start();
         require 'fiche.php';
         $contenu = ob_get_clean();
      }
   }

   public function liste()
   {
      $restos = new Restos();

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
   }

   public function delete()
   {
      $restos = new Restos();

      if (isset($url[1])) {
         $id = $url[1];
         $restos->delete($id);
      }

      $resultatRequete = $restos->liste();
      ob_start();
      require 'liste.php';
      $contenu = ob_get_clean();
   }

   public function ajout()
   {
      $restos = new Restos();
      $fillable = $restos->getFillable();
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
   }

   public function edit()
   {
      $restos = new Restos();
      $fillable = $restos->getFillable();
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
   }

   public function erreur404()
   {
      ob_start();
      echo "Vous n'avez pas accès à cette page.";
      $contenu = ob_get_clean();
   }
}