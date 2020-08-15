<?php
// Décalaration dynamique des variables
foreach ($resto as $cle => $valeur) {
   $$cle = $valeur;
}

if(isset($adresse) == false){
   $adresse = [];
}

foreach ($fillableAdresse as $valeur) {
   if(isset($$valeur) == false)
      $$valeur = isset($adresse[$valeur]) ? $adresse[$valeur] : '';
}

?>
<div class="row flex-wrap centre p-4">
   <h1>Création/MAJ de restaurant</h1>
   <div class="col-12 centre p-1">
      <form action="" method="POST" class="needs-validation p-3" style="max-width:600px">
         <div class="form-row justify-content-center pb-3">
            <div class="col-6 mb-3">
               <label for="nom">Nom</label>
               <input type="text" name="nom" class="form-control " value="<?php echo $nom ?>">

            </div>
            <div class="col-6 mb-3">
               <label for="numrue">Numéro</label>
               <input type="number" name="numrue" class="form-control " value="<?php echo $numrue ?>">

            </div>
         </div>
         
         <div class="form-row justify-content-center pb-3">
            <div class="col-6 mb-3">
               <label for="nomrue">Rue</label>
               <input type="text" name="nomrue" class="form-control " value="<?php echo $nomrue ?>">

            </div>
            <div class="col-6 mb-3">
               <label for="cp">Code postal</label>
               <input type="number" name="cp" class="form-control " value="<?php echo $cp ?>">

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
               <label for="ville">Ville</label>
               <input type="text" name="ville" class="form-control " value="<?php echo $ville ?>">

            </div>
            <div class="col-6 mb-3">
               <label for="pays">Pays</label>
               <input type="text" name="pays" class="form-control " value="<?php echo $pays ?>">

            </div>
         </div>

         <div class="form-row justify-content-center pb-3">
            <div class="col-6 mb-3">
               <label for="latitude">Latitude</label>
               <input type="number" step="any"  name="latitude" class="form-control " value="<?php echo $latitude ?>">

            </div>

            <div class="col-6 mb-3">
               <label for="longitude">Longitude</label>
               <input type="number" step="any" name="longitude" class="form-control " value="<?php echo $longitude ?>">

            </div>
         </div>
         <div class="centre mt-4"><button class="btn btn-primary px-5" type="submit">Valider</button></div>
      </form>
   </div>
</div>