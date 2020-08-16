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

      if (isset($url[1]))
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

         $resto = [];
         // On récupère le resto renvoyé par la méthode fiche($_id)
         foreach ($resultatRequete as $value)
            $resto = $value;

         // On accède pour la 1ère fois à la page edit
         if(!isset($requetePOST['id'])){
            // Déclaration dynamique des variables définies dans le resto
            foreach ($resto as $cle => $valeur)
               $$cle = $valeur;

            if(isset($adresse) == false) // si le resto ne contient aucune donnée de resto
               $adresse = [];

            // On crée toutes les variables présentes dans fillable qui ne sont pas définies pour ce restaurant
            foreach ($fillableAdresse as $valeur)
               $adresse[$valeur] = isset($resto['adresse'][$valeur]) ? $resto['adresse'][$valeur] : '';
            
            require  './vues/form-adresse.php';
            return;

         // Validation du formulaire depuis la page editadresse
         }else{
            $adresse = verifInputsAdresse($requetePOST, $fillableAdresse);
            if($adresse === false){
               header('Location:'.SITE.'erreur404');
               return;
            }
            
            if($adresse == []) // S'il n'y a aucune donnée d'adresse, alors on supprime la clé
               $restos->deleteKey($_id, ['adresse' => '']);
            else
               $restos->editadresse($_id, $adresse);
   
            header('Location:'.SITE.'fiche/'.$_id);
            return;
         }
      }

      header('Location:'.SITE.'erreur404');
   }
}