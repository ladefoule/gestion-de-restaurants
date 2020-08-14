<?php 

/**
 * La fonction vérifie si les inputs correspondent bien aux inputs autorisés dans le modèle
 * On renvoie false si la vérif échoue
 * On renvoie un tableau avec les infos du restos reçus
 *
 * @param array $POST
 * @param array $fillable
 * @return void
 */
function verifInputs(array $POST, array $fillable)
{
   foreach ($POST as $cle => $valeur) {
      $resto[$cle] = $valeur;
      if(!in_array($cle, $fillable)){
         return false;
      }
   }

   return $resto;
}

spl_autoload_register(function ($class_name) {
   include $class_name . '.php';
});