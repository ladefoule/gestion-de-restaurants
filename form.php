<?php 

foreach ($result as $resto) {
   //var_dump($rest);
   //$id = $resto->_id;
   $nom = $resto->nom;
   $site = $resto->site;
   $tel = $resto->tel;
   $presentation = $resto->presentation;
   $tarif_min = $resto->tarif_min;
   $tarif_max = $resto->tarif_max;
}
?>
<div class="row flex-wrap centre p-4">
   <h1>Création de restaurant</h1>
   <div class="col-12 centre p-1">
      <form action="" method="POST" class="needs-validation p-3">
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
            <div class="col-6 mb-3">
               <label for="site">Site</label>
               <input type="text" name="site" class="form-control " value="<?php echo $site ?>" placeholder="Site">

            </div>
            <div class="col-6 mb-3">
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
            if(isset($_GET['id'])){
               $id = $_GET['id'];
               echo "<input type=\"hidden\" name='maj'>";
               echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
            }
            ?>
         </div>

         <div class="form-row justify-content-center pb-3">
            <div class="col-6 mb-3">
               <label for="latitude">Latitude</label>
               <input type="number" step="any" name="latitude" class="form-control " value="<?php echo $latitude ?>" placeholder="">

            </div>
            <div class="col-6 mb-3">
               <label for="longitude">Longitude</label>
               <input type="number" step="any" name="longitude" class="form-control " value="<?php echo $longitude ?>" placeholder="">

            </div>
         </div>
         <div class="centre mt-4"><button class="btn btn-primary px-5" type="submit">Valider</button></div>
      </form>
   </div>
</div>