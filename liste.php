<div class="row">
   <table class="table table-striped table-dark">
      <thead>
         <tr>
            <th scope="col">#</th>
            <th scope="col"><a href="http://192.168.205.63/php/semaine-10/jeudi/resto/liste/nom/asc/">Nom</a></th>
            <th scope="col"><a href="http://192.168.205.63/php/semaine-10/jeudi/resto/liste/tel/asc/">Tel</a></th>
            <th scope="col">Site</th>
            <th scope="col"><a href="http://192.168.205.63/php/semaine-10/jeudi/resto/liste/tarif_min/asc/">Tarif Min</a></th>
            <th scope="col"><a href="http://192.168.205.63/php/semaine-10/jeudi/resto/liste/tarif_max/asc/">Tarif Max</a></th>
            <th scope="col">Modifier</th>
            <th scope="col">Supprimer</th>
         </tr>
      </thead>
      <tbody>
         <?php
         $i = 0;
         foreach ($restos as $resto) {
            $i++;
            $id = $resto->_id;
            $nom = $resto->nom;
            $site = $resto->site;
            $tel = $resto->tel;
            $tarif_min = $resto->tarif_min;
            $tarif_max = $resto->tarif_max;

            echo '<br>';
            echo "<tr>";
            echo "<th scope='row'>$i</th>";
            echo "<td><a href='http://192.168.205.63/php/semaine-10/jeudi/resto/fiche/$id'>$nom</a></td>";
            echo "<td>$tel</td>";
            echo "<td><a href='$site'><i class=\"fas fa-globe-europe\"></i></a></td></td>";
            echo "<td>$tarif_min</td>";
            echo "<td>$tarif_max</td>";
            echo "<td><a href='http://192.168.205.63/php/semaine-10/jeudi/resto/edit/$id'><i class='fas fa-edit'></i></a></td></td>";
            echo "<td><a href='http://192.168.205.63/php/semaine-10/jeudi/resto/delete/$id'><i class='far fa-trash-alt'></i></a></td></td>";
            echo "</tr>";
         }
         ?>
      </tbody>
   </table>
</div>