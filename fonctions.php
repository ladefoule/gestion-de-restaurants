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
   $args = array(
      'nom'      => FILTER_SANITIZE_SPECIAL_CHARS,
      'vie'      => array('filter' => FILTER_VALIDATE_INT,
                          'options' => array('min_range' => 0, 'max_range' => 100)),
      'degats'   => array('filter' => FILTER_VALIDATE_INT,
                          'options' => array('min_range' => 0, 'max_range' => 20)),
      'photo'    => FILTER_SANITIZE_ENCODED,
   );

   $myInputs = filter_var_array($POST, $args);

   foreach ($POST as $cle => $valeur) {
      $resto[$cle] = $valeur;
      if(!in_array($cle, $fillable)){
         return false;
      }

      if(floatval($value))
         $resto[$key] = floatval($value);
   }

   return $resto;
}

spl_autoload_register(function ($class_name) {
   if(file_exists('modeles/'.$class_name . '.php'))
      require_once 'modeles/'.$class_name . '.php';
   
   if(file_exists('controllers/'.$class_name . '.php'))
      require_once 'controllers/'.$class_name . '.php';
});