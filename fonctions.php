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
      // Si on envoie un input qui n'est pas autorisé
      if(in_array($cle, $fillable) == false)
         return false;

      // On n'insère pas les clés qui ont des valeurs vides et qui ont passé le test de validation
      if($valeur !== false && $valeur != ''){
         if(in_array($cle, $intKeys))
            $resto[$cle] = intval($valeur);
         else
            $resto[$cle] = htmlspecialchars($valeur);
      }
   }

   return $resto;
}

function verifInputsAdresse(array $POST, array $fillableAdresse)
{
   $args = array(
      'cp'      => array('filter' => FILTER_VALIDATE_INT,
                          'options' => array('min_range' => 1000, 'max_range' => 99999)),
      'rue'      => FILTER_SANITIZE_SPECIAL_CHARS,
      'latitude'      => array('filter' => FILTER_VALIDATE_FLOAT,
                           'options' => array('min_range' => -90, 'max_range' => 90)),
      'longitude'      => array('filter' => FILTER_VALIDATE_FLOAT,
                           'options' => array('min_range' => -90, 'max_range' => 90)),
      'pays'      => FILTER_SANITIZE_SPECIAL_CHARS,
      'ville'      => FILTER_SANITIZE_SPECIAL_CHARS,
   );

   $myInputs = filter_var_array($POST, $args);
   $floatKeys = ['longitude', 'latitude'];
   $intKeys = ['cp'];
   $resto = [];

   foreach ($myInputs as $cle => $valeur) {
      // Si on envoie un input qui n'est pas autorisé
      if(in_array($cle, $fillableAdresse) == false)
         return false;

      // On n'insère pas les clés qui ont des valeurs vides et qui ont passé le test de validation
      if($valeur !== false && $valeur != ''){
         if(in_array($cle, $floatKeys))
            $resto['adresse'][$cle] = floatval($valeur);
         else if(in_array($cle, $intKeys))
            $resto['adresse'][$cle] = intval($valeur);
         else
            $resto['adresse'][$cle] = htmlspecialchars($valeur);
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
   $resto['presentation'] = $faker->realText($maxNbChars = 400, $indexSize = 2);

   $resto['adresse']['rue'] = $faker->streetAddress;
   $resto['adresse']['cp'] = rand(10000, 99999);
   $resto['adresse']['ville'] = $faker->city;
   $resto['adresse']['pays'] = $faker->country;
   $resto['adresse']['longitude'] = $faker->randomFloat($nbMaxDecimals = 10, $min = -90, $max = 90) ;
   $resto['adresse']['latitude'] = $faker->randomFloat($nbMaxDecimals = 10, $min = -90, $max = 90) ;

   return $resto;
}

spl_autoload_register(function ($class_name) {
   if(file_exists('modeles/'.$class_name . '.php'))
      require_once 'modeles/'.$class_name . '.php';
   
   if(file_exists('controllers/'.$class_name . '.php'))
      require_once 'controllers/'.$class_name . '.php';
});