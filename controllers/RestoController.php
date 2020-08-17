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
      $url = explode('/', $array['requeteGET']);

      if (isset($url[1]) == false){
         ErreurController::erreur404(ID_NON_RENSEIGNE);
         return;
      }

      $id = $url[1];
      try {
         $_id = new MongoDB\BSON\ObjectId($id);
      } catch (Exception $e) {
         ErreurController::erreur404(ID_INCORRECT);
         return;
      }
      $resultatRequete = $restos->fiche($_id);
      if($resultatRequete->isDead()){
         ErreurController::erreur404(RESTO_INCONNU);
         return;
      }

      foreach ($resultatRequete as $value)
         $resto = $value;

      $moyenne = $restos->moyenneNotes($_id);
      if($moyenne->isDead()){
         ErreurController::erreur404(RESTO_INCONNU);
         return;
      }
      foreach ($moyenne as $value)
         $moyenne = ( $value['moyenne'] * 100 ) / 5; // On convertit la moyenne en fonction de la taille de notre div qui contient les étoiles
         
      require  './vues/fiche.php';
      return;
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

      if (isset($url[1]) == false){
         ErreurController::erreur404(ID_NON_RENSEIGNE);
         return;
      }

      $id = $url[1];
      try {
         $_id = new MongoDB\BSON\ObjectId($id);
      } catch (Exception $e) {
         ErreurController::erreur404(ID_INCORRECT);
         return;
      }
      $resultatRequete = $restos->delete($_id);
      if($resultatRequete->getDeletedCount() == 0){
         ErreurController::erreur404(RESTO_INCONNU);
         return;
      }

      header('Location:'.SITE.'liste');
      return;
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
         require  './vues/form.php';
         return;      
      }else {// Si on reçoit des infos venant du formulaire (POST)
         $requete = $array['requetePOST'];
         $resto = verifInputs($requete);      
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
      $url = explode('/', $array['requeteGET']);
      $requetePOST = $array['requetePOST'];

      if (isset($url[1]) == false){
         ErreurController::erreur404(ID_NON_RENSEIGNE);
         return;
      }

      $id = $url[1];
      try {
         $_id = new MongoDB\BSON\ObjectId($id);
      } catch (Exception $e) {
         ErreurController::erreur404(ID_INCORRECT);
         return;
      }
      $resultatRequete = $restos->fiche($_id);
      if($resultatRequete->isDead()){
         ErreurController::erreur404(RESTO_INCONNU);
         return;
      }

      // On récupère le resto (fiche($id) renvoie que 1 seul resto)
      foreach ($resultatRequete as $value) 
         $resto = $value;

      if(!isset($requetePOST['id'])){// On accède pour la 1ère fois à la page edit
         require  './vues/form.php';
         return;
      }else{// Validation du formulaire depuis la page edit
         $resto = verifInputs($requetePOST);      
         $restos->edit($_id, $resto);
         header('Location:'.SITE.'fiche/'.$_id);
         return;
      }
   }

   /**
    * Ajout d'une note au resto
    *
    * @param array $array
    * @return void
    */
   public static function ajoutnote(array $array)
   {
      $restos = $array['restos'];
      $url = explode('/', $array['requeteGET']);
      $requetePOST = $array['requetePOST'];

      if (isset($url[1]) == false){
         ErreurController::erreur404(ID_NON_RENSEIGNE);
         return;
      }
         
      $id = $url[1];
      try {
         $_id = new MongoDB\BSON\ObjectId($id);
      } catch (Exception $e) {
         ErreurController::erreur404(ID_INCORRECT);
         return;
      }

      // Note automatique avec faker
      if( in_array('faker', $url) ){
         $note = genererNoteFaker();
         $restos->ajoutnote($_id, $note);
         header('Location:'.SITE.'fiche/'.$id);
         return;
      }
      
      $resultatRequete = $restos->fiche($_id);
      if($resultatRequete->isDead()){
         ErreurController::erreur404(RESTO_INCONNU);
         return;
      }

      foreach ($resultatRequete as $value)
         $resto = $value;

      if(!isset($requetePOST['id'])){// On accède pour la 1ère fois à la page ajout note
         require  './vues/form-note.php';
         return;
      }else{// Validation du formulaire
         $note = verifInputsNotes($requetePOST);
         if($note == []){
            ErreurController::erreur404("Merci de renseigner au moins une note ou un commentaire");
            return;
         }
      
         $restos->ajoutNote($_id, $note);
         header('Location:'.SITE.'fiche/'.$_id);
         return;
      }
   }
}