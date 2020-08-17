<style>
   /*code CSS pour les étoiles */
   .tde {
      height: 20px;
      width: 20px;
      cursor: pointer;
   }

   #moyenne {
      height: 20px;
      width: <?= $moyenne; ?>px;
      background: #E0E001;
   }

   #glob {
      display: flex;
   }
</style>
<div class="row centre">
   <div class="card p-3" style="max-width:600px">
      <a style="position:absolute;right:-2px;top:-5px" href="<?php echo SITE . 'edit/' . $id ?>"><i class='fas fa-edit'></i></a>
      <img src="<?php echo SITE . 'img/lorempixel-' . rand(1, 10) . '.jpg' ?>" class="card-img-top" alt="...">
      <div class="card-body">
         <h5 class="card-title font-weight-bold h1"><?= $resto->nom ?></h5>
         <div class="flex mb-4" style="width:100px;float:left;">
            <!--div en arrière-plan qui s'allongera en fonction de la valeur de $value-->
            <div id="moyenne">

               <!--div qui contient les étoiles-->
               <div id="glob">
                  <img id="tde_1" src="<?php echo SITE ?>img/star.png" class="tde">
                  <img id="tde_2" src="<?php echo SITE ?>img/star.png" class="tde">
                  <img id="tde_3" src="<?php echo SITE ?>img/star.png" class="tde">
                  <img id="tde_4" src="<?php echo SITE ?>img/star.png" class="tde">
                  <img id="tde_5" src="<?php echo SITE ?>img/star.png" class="tde">
               </div>
            </div>
         </div>
         <a class="float:left" href="<?php echo SITE.'ajoutnote/'.$id ?>">Noter?</a>
         <a class="float:left" href="<?php echo SITE.'ajoutnote/'.$id.'/faker' ?>">Noter (faker)?</a>
         
         <?php
            echo '<textarea class="form-control mb-4" id="presentation" rows="6" readonly>' . ($resto->presentation ?? '') . '</textarea>';

         echo '<p>';

         $cuisines = $resto->cuisines ?? [];
         $listeCuisines = tabCuisineEnChaine($cuisines);
         if ($listeCuisines != '')
            echo "<b>Cuisines :</b> $listeCuisines <br><br>";

         if (isset($resto->tel))
            echo "<b>Tél :</b> $resto->tel <br>";

         if (isset($resto->tarif_max) && isset($resto->tarif_min))
            echo "<b>Tarif :</b> $resto->tarif_min-$resto->tarif_max €<br><br>";

         if (isset($resto->adresse) && $resto->adresse != []) {
            echo '<b>Adresse :</b> <a href="' . SITE . 'editadresse/' . $id . '"><i class="fas fa-edit"></i></a><br>';
            echo ($resto->adresse['rue'] ?? '') . '<br>';
            echo ($resto->adresse['cp'] ?? '') . ' ' . ($resto->adresse['ville'] ?? '') . '<br>';
            echo ($resto->adresse['pays'] ?? '') . '<br>';

            if (isset($resto->adresse['longitude']) && isset($resto->adresse['latitude']))
               echo 'Localisattion : <a href="https://www.openstreetmap.org/#map=19/' . $resto->adresse['latitude'] . '/' . $resto->adresse['longitude'] . '" target="_blank"><i class="fas fa-globe-europe"></i></a>';
         }

         echo '</p>';
         if (isset($resto->site))
            echo '<a href="' . $resto->site . '" class="btn btn-primary" target="_blank">' . $resto->site . '</a>';
         ?>
      </div>
   </div>
</div>