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
      'tel'    => FILTER_SANITIZE_SPECIAL_CHARS,
      'site'    => FILTER_VALIDATE_URL,
      'presentation'    => FILTER_SANITIZE_SPECIAL_CHARS,
   );

   $myInputs = filter_var_array($POST, $args);
   $intKeys = ['tarif_min', 'tarif_max'];
   $resto = [];

   foreach ($myInputs as $cle => $valeur) {
      if(in_array($cle, $fillable) == false)
         return false;

      if($valeur !== false && $valeur != ''){
         if(in_array($cle, $intKeys))
            echo $resto[$cle] = intval($valeur);
         else
            echo $resto[$cle] = htmlspecialchars($valeur);
      }
   }

   return $resto;
}

function verifInputsAdresse(array $POST, array $fillableAdresse)
{
   $args = array(
      'nom'      => FILTER_SANITIZE_SPECIAL_CHARS,
      'cp'      => array('filter' => FILTER_VALIDATE_INT,
                          'options' => array('min_range' => 1000, 'max_range' => 99999)),
      'numrue'      => FILTER_VALIDATE_INT,
      'nomrue'      => FILTER_SANITIZE_SPECIAL_CHARS,
      'latitude'      => array('filter' => FILTER_VALIDATE_FLOAT,
                           'options' => array('min_range' => -90, 'max_range' => 90)),
      'longitude'      => array('filter' => FILTER_VALIDATE_FLOAT,
                           'options' => array('min_range' => -90, 'max_range' => 90)),
      'pays'      => FILTER_SANITIZE_SPECIAL_CHARS,
      'ville'      => FILTER_SANITIZE_SPECIAL_CHARS,
   );

   $myInputs = filter_var_array($POST, $args);
   $floatKeys = ['longitude', 'latitude'];
   $intKeys = ['numrue', 'cp'];
   $resto = [];

   $resto['nom'] = htmlspecialchars($myInputs['nom']);
   unset($myInputs['nom']);

   foreach ($myInputs as $cle => $valeur) {
      if(in_array($cle, $fillableAdresse) == false)
         return false;

      if($valeur !== false && $valeur != ''){
         if(in_array($cle, $floatKeys))
            echo $resto['adresse'][$cle] = floatval($valeur);
         else if(in_array($cle, $intKeys))
            echo $resto['adresse'][$cle] = intval($valeur);
         else
            echo $resto['adresse'][$cle] = htmlspecialchars($valeur);
      }
   }

   return $resto;
}

/**
 * Génération aleatoire de resto
 *
 * @return array
 */
function genererRestoFaker()
{
   $faker = Faker\Factory::create('fr_FR');
   $resto['nom'] = $faker->company;
   $resto['tel'] = $faker->PhoneNumber;
   $resto['site'] = 'http://'.$faker->domainName;
   $resto['tarif_min'] = rand(1, 10);
   $resto['tarif_max'] = rand(11, 50);
   $resto['longitude'] = $faker->randomFloat($nbMaxDecimals = 10, $min = -90, $max = 90) ;
   $resto['latitude'] = $faker->randomFloat($nbMaxDecimals = 10, $min = -90, $max = 90) ;
   $resto['presentation'] = $faker->realText($maxNbChars = 400, $indexSize = 2);
   $resto['adresse'] = $faker->address;

   return $resto;
}

spl_autoload_register(function ($class_name) {
   if(file_exists('modeles/'.$class_name . '.php'))
      require_once 'modeles/'.$class_name . '.php';
   
   if(file_exists('controllers/'.$class_name . '.php'))
      require_once 'controllers/'.$class_name . '.php';
});