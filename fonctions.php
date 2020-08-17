<?php 

/**
 * La fonction vérifie si les inputs correspondent bien aux inputs autorisés dans le modèle
 * On renvoie false si la vérif échoue
 * On renvoie un tableau avec les infos du restos reçus
 *
 * @param array $POST
 * @return void
 */
function verifInputs(array $POST)
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
      'cuisines'    => FILTER_SANITIZE_SPECIAL_CHARS,
   );

   $myInputs = filter_var_array($POST, $args);

   $resto = [];
   foreach ($myInputs as $cle => $valeur)
      if($valeur !== false && $valeur != '')
         if($cle == 'cuisines')
            $resto[$cle] = explode('/', $valeur);
         else
            $resto[$cle] = $valeur; 

   return $resto;
}

function verifInputsAdresse(array $POST)
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

   $adresse = [];
   foreach ($myInputs as $cle => $valeur)
      if($valeur !== false && $valeur != '')
         $adresse[$cle] = $valeur;

   return $adresse;
}

function verifInputsNotes(array $POST)
{
   $args = array(
      'note'      => array('filter' => FILTER_VALIDATE_INT,
                          'options' => array('min_range' => 1, 'max_range' => 5)),
      'commentaire'      => FILTER_SANITIZE_SPECIAL_CHARS,
   );

   $myInputs = filter_var_array($POST, $args);
   
   $note = [];
   foreach ($myInputs as $cle => $valeur)
      if($valeur !== false && $valeur != '')
            $note[$cle] = intval($valeur);

   return $note;
}

/**
 * Génération aleatoire de note
 *
 * @return array
 */
function genererNoteFaker()
{
   $faker = Faker\Factory::create('fr_FR');
   $note['note'] = rand(1, 5);
   $note['commentaire'] = $faker->realText($maxNbChars = 30, $indexSize = 2);
   return $note;
}

/**
 * Génération aleatoire de resto
 *
 * @return array
 */
function genererRestoFaker()
{
   $cuisinesMonde = ["albanaise","allemande","bavaroise","autrichienne","basque","belge","britannique","anglaise","écossaise","galloise","bulgare","chypriote","danoise",
   "espagnole","galicienne","finlandaise","française","alsacienne","angevine","bourguignonne","gersoise","lyonnaise","grecque","hongroise","italienne","irlandaise",
   "islandaise","lituanienne","luxembourgeoise","macédonienne","maltaise","monténégrine","néerlandaise","norvégienne","polonaise","portugaise","roumaine et molda",
   "russe","serbe","slovaque","suédoise","suisse","tchèque","ukrainienne"];

   $cuisinesFR = ["française","alsacienne","angevine","bourguignonne","gersoise","lyonnaise"];

   $choixCuisines = $cuisinesFR;

   $faker = Faker\Factory::create('fr_FR');
   $resto['nom'] = $faker->company;
   $resto['tel'] = $faker->PhoneNumber;
   $resto['site'] = 'http://'.$faker->domainName;
   $resto['tarif_min'] = rand(1, 10);
   $resto['tarif_max'] = rand(11, 50);
   $resto['presentation'] = $faker->realText($maxNbChars = 400, $indexSize = 2);

   // On insère au plus 3 cuisines en évitant les doublons
   for ($i=0; $i < 3; $i++){
      $randCuisine = $choixCuisines[rand(0, count($choixCuisines)-1)];
      if(in_array($randCuisine, $resto['cuisines']) == false)
         $resto['cuisines'][] = $randCuisine;
   }

   $resto['adresse']['rue'] = $faker->streetAddress;
   $resto['adresse']['cp'] = rand(10000, 99999);
   $resto['adresse']['ville'] = $faker->city;
   $resto['adresse']['pays'] = $faker->country;
   $resto['adresse']['longitude'] = $faker->randomFloat($nbMaxDecimals = 10, $min = -90, $max = 90) ;
   $resto['adresse']['latitude'] = $faker->randomFloat($nbMaxDecimals = 10, $min = -90, $max = 90) ;

   // On insère 4 notes
   for ($i=0; $i < 3; $i++){
      $resto['notes'][] = ['note' => rand(1, 5), 'commentaire' => $faker->realText($maxNbChars = 30, $indexSize = 2)];
   }

   return $resto;
}

function tabCuisineEnChaine($cuisines)
{
   $listeCuisines = '';
   foreach ($cuisines as $cuisine) // On construit la chaines des cuisines
      $listeCuisines = $listeCuisines . ($listeCuisines == '' ? '' : '/') . $cuisine;

   return $listeCuisines;
}

spl_autoload_register(function ($class_name) {
   if(file_exists('modeles/'.$class_name . '.php'))
      require_once 'modeles/'.$class_name . '.php';
   
   if(file_exists('controllers/'.$class_name . '.php'))
      require_once 'controllers/'.$class_name . '.php';
});