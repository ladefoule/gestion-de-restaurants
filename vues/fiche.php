<?php
// Dans le résultat de la requète il n'y a qu'un seul resto
foreach ($resultatRequete as $cle => $resto) {
   // Décalaration dynamique des variables
   foreach ($resto as $cle => $valeur) {
      $$cle = $valeur;
   }
}
?>
<div class="row centre">
   <div class="card w-50 p-3">
      <a style="position:absolute;right:-2px;top:-5px" href="<?php echo SITE .'edit/'.$id ?>"><i class='fas fa-edit'></i></a>
      <img src="http://lorempixel.com/600/400/food" class="card-img-top" alt="...">
      <div class="card-body">
         <h5 class="card-title font-weight-bold h1"><?= $nom ?></h5>
         <?php
            if($presentation != '')
               echo '<textarea class="card-text" id="presentation">'.$presentation.'</textarea>';
            
            echo '<p>';

               if($tel != '')
                  echo "Tél : $tel <br>";

               if($tarif_max != '' && $tarif_min != '')
                  echo "Tarif : $tarif_min-$tarif_max €<br>";

               if($longitude != '' && $latitude != '')
                  echo 'Localisattion : <a href="https://www.openstreetmap.org/#map=19/'.$latitude.'/'.$longitude.'" target="_blank"><i class="fas fa-globe-europe"></i></a>';

            echo '</p>';
            if($site != '')
               echo '<a href="'.$site.'" class="btn btn-primary" target="_blank">'.$site.'</a>';
         ?>
      </div>
   </div>
</div>