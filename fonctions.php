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
      'tarif_min'      => array('filter' => FILTER_VALIDATE_INT,
                          'options' => array('min_range' => 0, 'max_range' => 100)),
      'tarif_max'   => array('filter' => FILTER_VALIDATE_INT,
                          'options' => array('min_range' => 0, 'max_range' => 100)),
      'latitude'      => FILTER_VALIDATE_FLOAT,
      'longitude'      => FILTER_VALIDATE_FLOAT,
      'tel'    => FILTER_SANITIZE_SPECIAL_CHARS,
      'site'    => FILTER_VALIDATE_URL,
      'presentation'    => FILTER_SANITIZE_SPECIAL_CHARS,
   );

   $myInputs = filter_var_array($POST, $args);
   var_dump($myInputs);
   $floatKeys = ['longitude', 'latitude'];
   $intKeys = ['tarif_min', 'tarif_max'];

   foreach ($myInputs as $cle => $valeur) {
      if(in_array($cle, $fillable) == false)
         return false;

      if($valeur !== false && $valeur != ''){
         if(in_array($cle, $floatKeys))
            echo $resto[$cle] = floatval($valeur);
         else if(in_array($cle, $intKeys))
            echo $resto[$cle] = intval($valeur);
         else
            echo $resto[$cle] = htmlspecialchars($valeur);
      }
   }

   return $resto;
}

spl_autoload_register(function ($class_name) {
   if(file_exists('modeles/'.$class_name . '.php'))
      require_once 'modeles/'.$class_name . '.php';
   
   if(file_exists('controllers/'.$class_name . '.php'))
      require_once 'controllers/'.$class_name . '.php';
});