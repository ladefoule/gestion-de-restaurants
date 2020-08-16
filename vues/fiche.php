<?php
   //$moyenne = 50;
?>
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
         <h5 class="card-title font-weight-bold h1"><?= $nom ?></h5>
         <div class="flex-12 mb-4" style="width:100px;">
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
            <a class="float:left" href="<?php echo SITE.'ajoutnote/'.$id ?>">Noter?</a>
         </div>
         
         <?php
         if ($presentation != '')
            echo '<textarea class="form-control mb-4" id="presentation" readonly>' . $presentation . '</textarea>';

         echo '<p>';

         if ($listeCuisines != '')
            echo "<b>Cuisines :</b> $listeCuisines <br><br>";

         if ($tel != '')
            echo "<b>Tél :</b> $tel <br>";

         if ($tarif_max != '' && $tarif_min != '')
            echo "<b>Tarif :</b> $tarif_min-$tarif_max €<br><br>";

         if ($adresse != []) {
            echo '<b>Adresse :</b> <a href="' . SITE . 'editadresse/' . $id . '"><i class="fas fa-edit"></i></a><br>';
            echo $adresse['rue'] . '<br>';
            echo $adresse['cp'] . ' ' . $adresse['ville'] . '<br>';
            echo $adresse['pays'] . '<br>';
            if ($adresse['longitude'] != '' && $adresse['latitude'] != '')
               echo 'Localisattion : <a href="https://www.openstreetmap.org/#map=19/' . $adresse['latitude'] . '/' . $adresse['longitude'] . '" target="_blank"><i class="fas fa-globe-europe"></i></a>';
         }

         echo '</p>';
         if ($site != '')
            echo '<a href="' . $site . '" class="btn btn-primary" target="_blank">' . $site . '</a>';
         ?>
      </div>
   </div>
</div>