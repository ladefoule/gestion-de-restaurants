<div class="row flex-wrap centre p-4">
   <h1>Création/MAJ de restaurant</h1>
   <div class="col-12 centre p-1">
      <form action="" method="POST" class="needs-validation p-3" style="max-width:600px">
         <div class="form-row justify-content-center pb-3">
            <div class="col-6 mb-3">
               <label for="nom">Nom</label>
               <input type="text" name="nom" class="form-control " value="<?php echo $nom ?>" placeholder="Nom">

            </div>
            <div class="col-6 mb-3">
               <label for="tel">Téléphone</label>
               <input type="text" name="tel" class="form-control " value="<?php echo $tel ?>" placeholder="Tél">

            </div>
         </div>

         <div class="form-row justify-content-center pb-3">
            <div class="col mb-3">
               <label for="presentation">Présentation</label>
               <textarea cols="40" rows="3" name="presentation" class="form-control " id="presentation" placeholder=""><?php echo $presentation ?></textarea>

            </div>
         </div>

         <div class="form-row justify-content-center pb-3">
            <div class="col-6 mb-3">
               <label for="tarif_min">Tarif Min</label>
               <input type="number" name="tarif_min" class="form-control " value="<?php echo $tarif_min ?>" placeholder="">

            </div>
            <div class="col-6 mb-3">
               <label for="tarif_max">Tarif Max</label>
               <input type="number" name="tarif_max" class="form-control " value="<?php echo $tarif_max ?>" placeholder="">

            </div>
            
            <?php
            if(isset($url[1])){
               $id = $url[1];
               echo "<input type=\"hidden\" name='maj'>";
               echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
            }
            ?>
         </div>

         <div class="form-row justify-content-center pb-3">
            <div class="col-6 mb-3">
               <label for="site">Site</label>
               <input type="text" name="site" class="form-control " value="<?php echo $site ?>" placeholder="Site">

            </div>
         </div>
         <div class="centre mt-4"><button class="btn btn-primary px-5" type="submit">Valider</button></div>
      </form>
   </div>
</div>