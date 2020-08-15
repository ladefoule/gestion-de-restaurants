<?php
class Controller
{
   public static function fiche(array $array)
   {
      $restos = $array['restos'];
      $fillable = $array['fillable'];
      $url = explode('/', $array['requeteGET']);

      if (isset($url[1])) {
         $id = $url[1];
         $resultatRequete = $restos->fiche($id);

         require  './vues/fiche.php';
      }
   }

   public static function liste(array $array)
   {
      $restos = $array['restos'];
      $url = explode('/', $array['requeteGET']);

      if(isset($url[1]) && isset($url[2])){
         $orderby = $url[1];
         $sens = $url[2];
         $sens = ($sens == 'asc') ? -1 : 1;

         $resultatRequete = $restos->liste($orderby, $sens);
      }else
         $resultatRequete = $restos->liste();

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
      $fillable = $array['fillable'];
      $resto = [];

      // Si le mot faker est present dans l'url alors on génère un resto
      $url = $array['requeteGET'];
      $url = explode('/', $url);
      if( in_array('faker', $url) )
         $resto = genererRestoFaker();

      // Si on accède pour la 1ère fois à la page d'ajout (formulaire)
      if(count($array['requetePOST']) == 0){
         require  './vues/form.php';

      // Si on reçoit des infos venant du formulaire (POST)
      }else {
         $requete = $array['requetePOST'];
         $resto = verifInputs($requete, $fillable);
         // Si la validation ne passe pas, on renvoie un message d'erreur
         if($resto == false){
            echo '<div class="alert alert-danger" role="alert"> Echec de l\'ajout </div>';
            return;
         }
      
         $restos->ajout($resto);
         header('Location:'.SITE.'liste');
      }
   }

   public static function edit(array $array)
   {
      $restos = $array['restos'];
      $fillable = $array['fillable'];
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
            require  './vues/form.php';

         // Validation du formulaire depuis la page edit
         }else{
            $resto = verifInputs($requetePOST, $fillable);

            // Si la validation ne passe pas, on renvoie un message d'erreur
            if($resto == false){
               echo '<div class="alert alert-danger" role="alert"> Echec de la mise à jour. </div>';
               return;
            }
         
            $restos->edit($id, $resto);
            header('Location:'.SITE.'fiche/'.$id);
         }
      }
   }

   public static function erreur404()
   {
      echo "Vous n'avez pas accès à cette page.";
   }
}