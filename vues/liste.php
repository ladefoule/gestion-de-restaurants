<div class="row centre p1">
   <div class="col-12">
      <h1>Liste des restaurants</h1>
   </div>
   <div class="col-12 col-lg-8 centre">
      <form action="" method="POST" class="needs-validation">
         <div class="form-row justify-content-center">
            <div class="col-6">
               <select name="choixcuisine" class="form-control">
                  <option value="">Toutes les cuisines</option>
                  <?php
                  foreach ($listeCuisines as $value) {
                     $selected = ($choixCuisine == $value) ? 'selected' : '';
                     echo "<option $selected value='$value'>$value</option>";
                  }
                  ?>
               </select>
            </div>
            <div class="col-6">
               <button class="btn btn-primary px-5" type="submit">Valider</button>
            </div>
         </div>
      </form>
   </div>
   <table class="table table-striped table-Default mt-3">
      <thead>
         <tr>
            <th scope="col">#</th>
            <th scope="col"><a href="<?= SITE ?>liste/nom/desc/">Nom</a></th>
            <th scope="col">Cuisines</th>
            <th scope="col"><a href="<?= SITE ?>liste/tarif_min/desc/">Tarifs</a></th>
            <th scope="col">Modifier</th>
            <th scope="col">Modifier<br>(adresse)</th>
            <th scope="col">Supprimer</th>
         </tr>
      </thead>
      <tbody>
         <?php
         foreach ($restos->getFillable() as $valeur) {
            $$valeur = ''; // On déclare toutes les variables pour éviter une erreur PHP
         }

         $compteur = 0;
         foreach ($listeRestos as $resto) {
            $compteur++;
            
            $id = isset($resto->_id) ? $resto->_id : '';
            $nom = isset($resto->nom) ? $resto->nom : '';
            $cuisines = isset($resto['cuisines']) ? $resto['cuisines'] : [];
            $tarif_min = isset($resto->tarif_min) ? $resto->tarif_min : '';
            $tarif_max = isset($resto->tarif_max) ? $resto->tarif_max : '';
            $tarif = $tarif_min.'-'.$tarif_max;

            $listeCuisines = '';
            foreach ($cuisines as $key => $value) {
               if($value == $choixCuisine) $value = '<b>'.$value.'</b>'; 
               $listeCuisines = $listeCuisines . ($listeCuisines == '' ? '' : '<br>') . $value;
            }

            echo '<br>';
            echo "<tr>";
            echo "<th scope='row'>$compteur</th>";
            echo "<td align='left'><a href='". SITE ."fiche/$id'>$nom</a></td>";
            echo "<td>$listeCuisines</td>";
            echo "<td>$tarif</td>";
            echo "<td><a href='". SITE ."edit/$id'><i class='fas fa-edit'></i></a></td></td>";
            echo "<td><a href='". SITE ."editadresse/$id'><i class='fas fa-edit'></i></a></td></td>";
            echo "<td><a href='". SITE ."delete/$id'><i class='far fa-trash-alt'></i></a></td></td>";
            echo "</tr>";
         }
         ?>
      </tbody>
   </table>
</div>