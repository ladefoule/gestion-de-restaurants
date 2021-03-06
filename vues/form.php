<div class="row flex-wrap centre p-1">
   <div class="col-12">
      <h1>Création/Maj d'un restaurant</h1>      
   </div>
   <div class="col-12 col-lg-8 centre p-1">
      <form action="" method="POST" class="needs-validation p-3 w-100">
         <div class="form-row justify-content-center pb-3">
            <div class="col-6 mb-3">
               <label for="nom">Nom</label>
               <input type="text" name="nom" class="form-control " value="<?php echo $resto->nom ?? '' ?>" placeholder="Nom">
            </div>
            <div class="col-6 mb-3">
               <label for="tel">Téléphone</label>
               <input type="text" name="tel" class="form-control " value="<?php echo $resto->tel ?? '' ?>" placeholder="Tél">
            </div>
         </div>
         <div class="form-row justify-content-center pb-3">
            <div class="col mb-3">
               <label for="presentation">Présentation</label>
               <textarea cols="40" rows="3" name="presentation" class="form-control " id="presentation" placeholder=""><?php echo $resto->presentation ?? '' ?></textarea>
            </div>
         </div>
         <div class="form-row justify-content-center pb-3">
            <div class="col-6 mb-3">
               <label for="tarif_min">Tarif Min</label>
               <input type="number" name="tarif_min" class="form-control " value="<?php echo $resto->tarif_min ?? '' ?>" placeholder="">
            </div>
            <div class="col-6 mb-3">
               <label for="tarif_max">Tarif Max</label>
               <input type="number" name="tarif_max" class="form-control " value="<?php echo $resto->tarif_max ?? '' ?>" placeholder="">
            </div> 
            <?php
            if(isset($id))
               echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
            ?>
         </div>
         <div class="form-row justify-content-center pb-3">
            <div class="col-6 mb-3">
               <label for="site">Site</label>
               <input type="text" name="site" class="form-control " value="<?php echo $resto->site ?? '' ?>" placeholder="Site">

            </div>
         </div>
         <div class="form-row justify-content-center pb-3">
            <div class="col-12 mb-3">
               <label for="cuisines">Cuisines</label>
               <input type="text" name="cuisines" class="form-control " value="<?php echo tabCuisineEnChaine($resto->cuisines ?? []) ?>" placeholder="Cuisine1/Cuisine2/Cuisine3">
            </div>
         </div>
         <div class="centre mt-4"><button class="btn btn-primary px-5" type="submit">Valider</button></div>
      </form>
   </div>
</div>