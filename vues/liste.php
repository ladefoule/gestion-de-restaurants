<div class="row centre">
   <table class="table table-striped table-secondary" style="max-width:800px">
      <thead>
         <tr>
            <th scope="col">#</th>
            <th scope="col"><a href="<?= SITE ?>liste/nom/desc/">Nom</a></th>
            <th scope="col"><a href="<?= SITE ?>liste/cuisine/asc/">Cuisine</a></th>
            <th scope="col"><a href="<?= SITE ?>liste/tarif_min/desc/">Tarif</a></th>
            <th scope="col">Modifier</th>
            <th scope="col">Modif (adresse)</th>
            <th scope="col">Supprimer</th>
         </tr>
      </thead>
      <tbody>
         <?php
         $i = 0;
         foreach ($restos->getFillable() as $valeur) {
            $$valeur = '';
         }
         foreach ($listeRestos as $resto) {
            $i++;
            
            $id = isset($resto->_id) ? $resto->_id : '';
            $nom = isset($resto->nom) ? $resto->nom : '';
            $cuisine = isset($resto['cuisine']) ? $resto['cuisine'] : '';
            $tarif_min = isset($resto->tarif_min) ? $resto->tarif_min : '';
            $tarif_max = isset($resto->tarif_max) ? $resto->tarif_max : '';
            $tarif = $tarif_min.'-'.$tarif_max;

            echo '<br>';
            echo "<tr>";
            echo "<th scope='row'>$i</th>";
            echo "<td align='left'><a href='". SITE ."fiche/$id'>$nom</a></td>";
            echo "<td>$cuisine</td>";
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