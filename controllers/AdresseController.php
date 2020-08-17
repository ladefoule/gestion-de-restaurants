<?php
class AdresseController
{
   /**
    * Modification de l'adresse d'un resto
    *
    * @param array $array
    * @return void
    */
   public static function editadresse(array $array)
   {
      $restos = $array['restos'];
      $fillableAdresse = $restos->getFillableAdresse();
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

      // On récupère le resto renvoyé par la méthode fiche($_id)
      foreach ($resultatRequete as $value)
         $resto = $value;

      // On accède pour la 1ère fois à la page edit
      if(!isset($requetePOST['id'])){        
         require  './vues/form-adresse.php';
         return;

      // Validation du formulaire depuis la page editadresse
      }else{
         $adresse = verifInputsAdresse($requetePOST, $fillableAdresse);
         if($adresse == []){
            $restos->deleteKey($_id, ['adresse' => '']);
            header('Location:'.SITE.'fiche/'.$_id);
            return;
         }
         
         $restos->editadresse($_id, ['adresse' => $adresse]);
         header('Location:'.SITE.'fiche/'.$_id);
         return;
      }
   }
}