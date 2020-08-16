<div class="row flex-wrap centre p-1">
   <div class="col-12">
      <h1>Noter un resto</h1>
   </div>
   <div class="col-12 col-lg-8 centre p-1">
      <form action="" method="POST" class="needs-validation p-3 w-100">
         <div class="form-row justify-content-center pb-3">
            <div class="col-6 mb-3">
               <label for="nom">Nom</label>
               <input type="text" class="form-control " value="<?php echo $nom ?>" disabled>

            </div>
         </div>
         
         <div class="form-row justify-content-center pb-3">
            <div class="col-12 mb-3">
               <label for="note">Note</label>
               <input type="number" name="note" class="form-control " value="" min='1' max='5'>

            </div>
            <div class="col-12 ">
               <label for="commentaire">Commentaire</label>
               <textarea name="commentaire" class="form-control " id="presentation" placeholder=""><?php echo $commentaire ?></textarea>

            </div>
            
            <?php
               echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
            ?>
         </div>
         <div class="centre mt-4"><button class="btn btn-primary px-5" type="submit">Valider</button></div>
      </form>
   </div>
</div>