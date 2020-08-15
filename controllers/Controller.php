<?php
class Controller
{
   public static function fiche(array $array)
   {
      $restos = $array['restos'];
      $fillable = $restos->getFillable();
      $fillableAdresse = $restos->getFillableAdresse();
      $url = explode('/', $array['requeteGET']);

      if (isset($url[1])) {
         $id = $url[1];
         $resultatRequete = $restos->fiche($id);
         foreach ($resultatRequete as $value)
            $resto = $value;

         // Décalaration dynamique des variables
         foreach ($resto as $cle => $valeur)
            $$cle = $valeur;

         // On crée toutes les variables présentes dans fillable qui ne sont pas définies pour ce restaurant
         foreach ($fillable as $valeur)
            if(isset($$valeur) == false)
               $$valeur = ''; 
         
         require  './vues/fiche.php';
      }
   }

   public static function liste(array $array)
   {
      $restos = $array['restos'];
      $fillable = $restos->getFillable();
      $url = explode('/', $array['requeteGET']);

      if(isset($url[1]) && isset($url[2])){
         $orderby = $url[1];
         if(in_array($orderby, $fillable) == false){
            Controller::erreur404();
            return;
         }
            
         $sens = $url[2];
         $sens = ($sens == 'asc') ? -1 : 1;

         $listeRestos = $restos->liste($orderby, $sens);
      }else
         $listeRestos = $restos->liste();

      require './vues/liste.php';
   }

   public static function delete(array $array)
   {
      $restos = $array['restos'];
      $url = explode('/', $array['requeteGET']);

      if (isset($url[1])) {
         $id = $url[1];
         $restos->delete($id);
      }

      header('Location:'.SITE.'liste');
   }

   public static function ajout(array $array)
   {
      $restos = $array['restos'];
      $fillable = $restos->getFillable();
      $resto = [];

      // Si le mot faker est present dans l'url alors on génère un resto
      $url = $array['requeteGET'];
      $url = explode('/', $url);
      if( in_array('faker', $url) ){
         $resto = genererRestoFaker();
         $restos->ajout($resto);
         header('Location:'.SITE.'liste');
         return;
      }
      // Si on accède pour la 1ère fois à la page d'ajout (formulaire)
      if(count($array['requetePOST']) == 0){
         // On crée toutes les variables présentes dans fillable
         foreach ($fillable as $valeur) {
            if(isset($$valeur) == false)
               $$valeur = '';
         }
         require  './vues/form.php';

      // Si on reçoit des infos venant du formulaire (POST)
      }else {
         $requete = $array['requetePOST'];
         $resto = verifInputs($requete, $fillable);
         // Si la validation ne passe pas, on renvoie un message d'erreur
         if($resto == false){
            Controller::erreur404();
            return;
         }
      
         $restos->ajout($resto);
         header('Location:'.SITE.'liste');
      }
   }

   public static function edit(array $array)
   {
      $restos = $array['restos'];
      $fillable = $restos->getFillable();
      $url = explode('/', $array['requeteGET']);
      $requetePOST = $array['requetePOST'];

      if (isset($url[1]))
      {
         $id = $url[1];
         $resultatRequete = $restos->fiche($id);
         foreach ($resultatRequete as $value)
            $resto = $value;

         // On accède pour la 1ère fois à la page edit
         if(!isset($requetePOST['id'])){
            // Décalaration dynamique des variables
            foreach ($resto as $cle => $valeur) {
               $$cle = $valeur;
            }

            // On crée toutes les variables présentes dans fillable qui ne sont pas définies pour ce restaurant
            foreach ($fillable as $valeur) {
               if(isset($$valeur) == false)
                  $$valeur = '';
            }
            require  './vues/form.php';

         // Validation du formulaire depuis la page edit
         }else{
            $resto = verifInputs($requetePOST, $fillable);

            // Si la validation ne passe pas, on renvoie un message d'erreur
            if($resto == false){
               Controller::erreur404();
               return;
            }
         
            $restos->edit($id, $resto);
            header('Location:'.SITE.'fiche/'.$id);
         }
      }
   }

   public static function editadresse(array $array)
   {
      $restos = $array['restos'];
      $fillableAdresse = $restos->getFillableAdresse();
      $url = explode('/', $array['requeteGET']);
      $requetePOST = $array['requetePOST'];

      if (isset($url[1]))
      {
         $id = $url[1];
         $resultatRequete = $restos->fiche($id);
         foreach ($resultatRequete as $value)
            $resto = $value;

         // On accède pour la 1ère fois à la page edit
         if(!isset($requetePOST['id'])){
            // Décalaration dynamique des variables
            foreach ($resto as $cle => $valeur)
               $$cle = $valeur;

            if(isset($adresse) == false)
               $adresse = [];

            foreach ($fillableAdresse as $valeur)
               if(isset($$valeur) == false)
                  $$valeur = isset($adresse[$valeur]) ? $adresse[$valeur] : '';
            
            require  './vues/form-adresse.php';

         // Validation du formulaire depuis la page edit
         }else{
            $resto = verifInputsAdresse($requetePOST, $fillableAdresse);

            // Si la validation ne passe pas, on renvoie un message d'erreur
            if($resto == false){
               Controller::erreur404();
               return;
            }
         
            $restos->editadresse($id, $resto);
            header('Location:'.SITE.'fiche/'.$id);
         }
      }
   }

   public static function erreur404()
   {
      echo "Erreur 404 : Une erreur s'est produite !";
   }
}