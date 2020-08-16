<div class="row centre">
   <div class="card p-3" style="max-width:600px">
      <a style="position:absolute;right:-2px;top:-5px" href="<?php echo SITE .'edit/'.$id ?>"><i class='fas fa-edit'></i></a>
      <img src="<?php echo SITE . 'img/lorempixel-' . rand(1, 10) . '.jpg' ?>" class="card-img-top" alt="...">
      <div class="card-body">
         <h5 class="card-title font-weight-bold h1"><?= $nom ?></h5>
         <?php
            if($presentation != '')
               echo '<textarea class="card-text" id="presentation">'.$presentation.'</textarea>';
            
            echo '<p>';

            if($listeCuisines != '')
               echo "<b>Cuisines :</b> $listeCuisines <br><br>";

            if($tel != '')
               echo "<b>Tél :</b> $tel <br>";

            if($tarif_max != '' && $tarif_min != '')
               echo "<b>Tarif :</b> $tarif_min-$tarif_max €<br><br>";

            if($adresse != [])
            {
               echo '<b>Adresse :</b> <a href="'.SITE.'editadresse/'.$id.'"><i class="fas fa-edit"></i></a><br>';
               echo $adresse['rue'] . '<br>';
               echo $adresse['cp'] . ' ' . $adresse['ville'] . '<br>';
               echo $adresse['pays'] . '<br>';
               if($adresse['longitude'] != '' && $adresse['latitude'] != '')
                  echo 'Localisattion : <a href="https://www.openstreetmap.org/#map=19/'.$adresse['latitude'].'/'.$adresse['longitude'].'" target="_blank"><i class="fas fa-globe-europe"></i></a>';
            }

            echo '</p>';
            if($site != '')
               echo '<a href="'.$site.'" class="btn btn-primary" target="_blank">'.$site.'</a>';
         ?>
      </div>
   </div>
</div>