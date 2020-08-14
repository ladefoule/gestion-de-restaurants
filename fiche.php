<?php
foreach ($result as $resto) {
   $nom = $resto->nom;
   $site = $resto->site;
   $tel = $resto->tel;
   $presentation = $resto->presentation;
   $tarif_min = $resto->tarif_min;
   $tarif_max = $resto->tarif_max;
}
?>
<div class="row centre">
   <div class="card w-50 p-3">
      <img src="http://lorempixel.com/600/400/food" class="card-img-top" alt="...">
      <div class="card-body">
         <h5 class="card-title font-weight-bold h1"><?= $nom ?></h5>
         <textarea class="card-text" id="presentation"><?= $presentation ?></textarea>
         <p>
            Tél : <?= $tel ?><br>
            Tarif : <?= $tarif_min . '-' . $tarif_max ?>€<br>
            Localisattion : <a href="https://www.openstreetmap.org/#map=19/<?=$latitude ?>/<?=$longitude ?>"><i class="fas fa-globe-europe"></i></a>
         </p>
         <a href="#" class="btn btn-primary"><?= $site ?></a>
      </div>
   </div>
</div>