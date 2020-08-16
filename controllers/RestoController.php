<?php
class RestoController
{
   /**
    * Accès à la fiche d'un resto
    *
    * @param array $array
    * @return void
    */
   public static function fiche(array $array)
   {
      $restos = $array['restos'];
      $fillable = $restos->getFillable();
      $fillableAdresse = $restos->getFillableAdresse();
      $url = explode('/', $array['requeteGET']);

      if (isset($url[1])) {
         $id = $url[1];
         try {
            $_id = new MongoDB\BSON\ObjectId($id);
         } catch (Exception $e) {
            header('Location:'.SITE.'erreur404');
            return;
         }
         $resultatRequete = $restos->fiche($_id);
         if($resultatRequete->isDead()){
            header('Location:'.SITE.'erreur404');
            return;
         }

         $resto = [];
         // On récupère le resto renvoyé par la méthode fiche($_id)
         foreach ($resultatRequete as $value)
            $resto = $value;

         // Déclaration dynamique des variables définies dans le resto
         foreach ($resto as $cle => $valeur)
            $$cle = $valeur;

         // On crée toutes les variables présentes dans fillable qui ne sont pas définies pour ce restaurant
         foreach ($fillable as $valeur)
            if(isset($$valeur) == false)
               $$valeur = ($valeur == 'cuisines') ? [] : ''; 
         
         $adresse = []; // La clé 'adresse' n'est pas dans fillable du coup on initialise la variable ici
         foreach ($fillableAdresse as $valeur) // On crée tous les index présents dans fillableAdresse qui ne sont pas définies pour ce restaurant
            $adresse[$valeur] = isset($resto['adresse'][$valeur]) ? $resto['adresse'][$valeur] : '';

         $listeCuisines = '';
         foreach ($cuisines as $key => $value) // On construit la chaines des cuisines
            $listeCuisines = $listeCuisines . ($listeCuisines == '' ? '' : '/') . $value;

         $moyenne = $restos->moyenneNotes($_id);
            
         require  './vues/fiche.php';
         return;
      }

      header('Location:'.SITE.'erreur404');
   }

   /**
    * Liste de tous les restos + filtres (asc, desc, type de cuisines)
    *
    * @param array $array
    * @return void
    */
   public static function liste(array $array)
   {
      $restos = $array['restos'];
      $fillable = $restos->getFillable();
      $url = explode('/', $array['requeteGET']);
      $requetePOST = $array['requetePOST'];
      $filtre = $projection = [];
      $choixCuisine = '';

      if(isset($url[1]) && isset($url[2])){ // Si on a des options de tri ex : liste/nom/desc
         $orderby = $url[1];
         if(in_array($orderby, $fillable) == false){
            header('Location:'.SITE.'erreur404');
            return;
         }
            
         $sens = $url[2];
         $sens = ($sens == 'asc') ? -1 : 1;
         $projection = ['sort' => [$orderby => $sens]];
      }
      
      // Sélection des restos par rapport à un type de cuisine
      if(count($requetePOST) != 0 && $requetePOST['choixcuisine'] != ''){
         $choixCuisine = $requetePOST['choixcuisine'];
         $filtre = ['cuisines' => $choixCuisine];
      }

      $listeCuisines = $restos->listeCuisines();
      $listeRestos = $restos->liste($filtre, $projection);

      require './vues/liste.php';
   }

   /**
    * Suppression d'un resto
    *
    * @param array $array
    * @return void
    */
   public static function delete(array $array)
   {
      $restos = $array['restos'];
      $url = explode('/', $array['requeteGET']);

      if (isset($url[1])) { // Si on a un ID
         $id = $url[1];
         try {
            $_id = new MongoDB\BSON\ObjectId($id);
         } catch (Exception $e) {
            header('Location:'.SITE.'erreur404');
            return;
         }
         $resultatRequete = $restos->delete($_id);
         if($resultatRequete->getDeletedCount() == 0){
            header('Location:'.SITE.'erreur404');
            return;
         }

         header('Location:'.SITE.'liste');
         return;
      }

      header('Location:'.SITE.'erreur404');
   }

   /**
    * Ajout d'un resto manuellement
    *
    * @param array $array
    * @return void
    */
   public static function ajout(array $array)
   {
      $restos = $array['restos'];
      $fillable = $restos->getFillable();

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
         $listeCuisines = '';
         require  './vues/form.php';
         return;

      // Si on reçoit des infos venant du formulaire (POST)
      }else {
         $requete = $array['requetePOST'];
         $resto = verifInputs($requete, $fillable);
         if($resto === false){
            header('Location:'.SITE.'erreur404');
            return;
         }
      
         $restos->ajout($resto);
         header('Location:'.SITE.'liste');
      }
   }

   /**
    * Modification d'un resto
    *
    * @param array $array
    * @return void
    */
   public static function edit(array $array)
   {
      $restos = $array['restos'];
      $fillable = $restos->getFillable();
      $url = explode('/', $array['requeteGET']);
      $requetePOST = $array['requetePOST'];

      if (isset($url[1])) // Si on a un ID
      {
         $id = $url[1];
         try {
            $_id = new MongoDB\BSON\ObjectId($id);
         } catch (Exception $e) {
            header('Location:'.SITE.'erreur404');
            return;
         }
         $resultatRequete = $restos->fiche($_id);
         if($resultatRequete->isDead()){
            header('Location:'.SITE.'erreur404');
            return;
         }

         foreach ($resultatRequete as $value) // On récupère le resto (fiche($id) renvoie que 1 seul resto)
            $resto = $value;

         // On accède pour la 1ère fois à la page edit
         if(!isset($requetePOST['id'])){
            // Décalaration dynamique des variables
            foreach ($resto as $cle => $valeur)
               $$cle = $valeur;

            // On crée toutes les variables présentes dans fillable qui ne sont pas définies pour ce restaurant
            foreach ($fillable as $valeur)
               if(isset($$valeur) == false)
                  $$valeur = ($valeur == 'cuisines') ? [] : ''; 

            $listeCuisines = '';
            foreach ($cuisines as $key => $value)
               $listeCuisines = $listeCuisines . ($listeCuisines == '' ? '' : '/') . $value;

            require  './vues/form.php';
            return;

         // Validation du formulaire depuis la page edit
         }else{
            $resto = verifInputs($requetePOST, $fillable);
            if($resto === false){
               header('Location:'.SITE.'erreur404');
               return;
            }
         
            $restos->edit($_id, $resto);
            header('Location:'.SITE.'fiche/'.$_id);
            return;
         }
      }

      header('Location:'.SITE.'erreur404');
   }

   public static function ajoutnote(array $array)
   {
      $restos = $array['restos'];
      $fillableNote = $restos->getFillableNote();
      $url = explode('/', $array['requeteGET']);
      $requetePOST = $array['requetePOST'];

      if (isset($url[1])) // Si on a un ID
      {
         $id = $url[1];
         try {
            $_id = new MongoDB\BSON\ObjectId($id);
         } catch (Exception $e) {
            header('Location:'.SITE.'erreur404');
            return;
         }
         $resultatRequete = $restos->fiche($_id);
         if($resultatRequete->isDead()){
            header('Location:'.SITE.'erreur404');
            return;
         }

         foreach ($resultatRequete as $value) // On récupère le resto (fiche($id) renvoie que 1 seul resto)
            $resto = $value;

            $nom = (isset($resto->nom) != false) ? $resto->nom : '';

         // On accède pour la 1ère fois à la page edit
         if(!isset($requetePOST['id'])){
            if(isset($resto['notes']) == false)
               $resto['notes'] = [];
            
            $commentaire = $note = '';

            require  './vues/form-note.php';
            return;
         // Validation du formulaire depuis la page edit
         }else{
            $note = verifInputsNotes($requetePOST, $fillableNote);
            if($note === false){
               header('Location:'.SITE.'erreur404');
               return;
            }
         
            $restos->ajoutNote($_id, $note);
            header('Location:'.SITE.'fiche/'.$_id);
            return;
         }
      }
   }
}