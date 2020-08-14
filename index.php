<?php

require 'vendor/autoload.php';
require 'config.php';

if(isset($_POST['nom']))
{
   $nom = $_POST['nom'];
   $tel = $_POST['tel'];
   $site = $_POST['site'];
   $presentation = $_POST['presentation'];
   $tarif_min = $_POST['tarif_min'];
   $tarif_max = $_POST['tarif_max'];

   $resto = [
      'nom' => $nom,
      'tel' => $tel,
      'site' => $site,
      'presentation' => $presentation,
      'tarif_min' => $tarif_min,
      'tarif_max' => $tarif_max
   ];

   // INSERTION DE RESTO
   if(!isset($_POST['maj'])){
      $restos->insertOne($resto);
      
   // MISE A JOUR DE RESTO
   }else{
      $id = $_POST['id'];
      $_id = new MongoDB\BSON\ObjectId($id);
      $restos->updateOne(['_id' => $_id, $resto]);
   }
}

// SUPPRESSION DE RESTO
if (isset($_GET['delete'])) {
   $id = $_GET['delete'];
   $_id = new MongoDB\BSON\ObjectId($id);
   $restos->deleteOne(
      ['_id' => $_id]
   );
}

//var_dump($retour);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
      crossorigin="anonymous">
      <script src="https://kit.fontawesome.com/fa79ab8443.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="style.css">
   <title>Création de restaurant</title>
</head>

<body>

   <div class="container">
<table class="table table-striped table-dark">
<thead>
   <tr>
      <th scope="col">#</th>
      <th scope="col">Nom</th>
      <th scope="col">Tel</th>
      <th scope="col">Site</th>
      <th scope="col" class="w-25">Présentation</th>
      <th scope="col">Tarif Min</th>
      <th scope="col">Tarif Max</th>
      <th scope="col">Modifier</th>
      <th scope="col">Supprimer</th>
   </tr>
</thead>
<tbody>
   <?php
$i = 0;
foreach ($restos->find() as $resto) {
   $i++;
   $id = $resto->_id;
   $nom = $resto->nom;
   $site = $resto->site;
   $tel = $resto->tel;
   $presentation = $resto->presentation;
   $tarif_min = $resto->tarif_min;
   $tarif_max = $resto->tarif_max;

   echo '<br>';
   echo "<tr>";
      echo "<th scope='row'>$i</th>";
      echo "<td>$nom</td>";
      echo "<td>$tel</td>";
      echo "<td><a href='$site'>$site</a></td></td>";
      echo "<td>$presentation</td>";
      echo "<td>$tarif_min</td>";
      echo "<td>$tarif_max</td>";
      echo "<td><a href='form.php?id=$id'><i class='fas fa-edit'></i></a></td></td>";
      echo "<td><a href='?delete=$id'><i class='far fa-trash-alt'></i></a></td></td>";
   echo "</tr>";
}
?>
</tbody>
</table>