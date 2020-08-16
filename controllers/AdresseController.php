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
         $resultatRequete = $restos->fiche($id);
         if($resultatRequete == false || $resultatRequete->isDead()){
            header('Location:'.SITE.'erreur404');
            return;
         }

         $resto = [];
         foreach ($resultatRequete as $value)
            $resto = $value;

         // On accède pour la 1ère fois à la page edit
         if(!isset($requetePOST['id'])){
            // Décalaration dynamique des variables du resto
            foreach ($resto as $cle => $valeur)
               $$cle = $valeur;

            if(isset($adresse) == false) // si le resto ne contient aucune donnée de resto
               $adresse = [];

            foreach ($fillableAdresse as $valeur) // On fait la même chose pour l'adresse
               $adresse[$valeur] = isset($resto['adresse'][$valeur]) ? $resto['adresse'][$valeur] : '';
            
            require  './vues/form-adresse.php';
            return;

         // Validation du formulaire depuis la page edit
         }else{
            $resto = verifInputsAdresse($requetePOST, $fillableAdresse);

            // Si la validation ne passe pas, on renvoie un message d'erreur
            if($resto == false){
               header('Location:'.SITE.'erreur404');
               return;
            }
         
            $restos->editadresse($id, $resto);
            header('Location:'.SITE.'fiche/'.$id);
            return;
         }
      }

      header('Location:'.SITE.'erreur404');
   }
}