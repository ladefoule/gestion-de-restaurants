<!DOCTYPE html>
<html lang="fr">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" crossorigin="anonymous">
   <script src="https://kit.fontawesome.com/fa79ab8443.js" crossorigin="anonymous"></script>
   <link rel="stylesheet" href="<?= SITE ?>style.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
   <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
   <title>Gestion de restaurants - MOUSSA</title>
</head>

<body>
   <div class="container">
      <!-- <div style="background:url('/php/gestion-de-restaurants/img/fond.jpg');height:200px;background-position:-300px">
         
      </div> -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
               <li class="nav-item active">
                  <a class="nav-link" href="<?= SITE ?>liste">Liste</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="<?= SITE ?>ajout">Ajout</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="<?= SITE ?>ajout/faker">Ajout (faker)</a>
               </li>
            </ul>
         </div>
      </nav>
      <?php echo $contenu ?>
      <script>
         var simplemde = new SimpleMDE({ element: document.getElementById("presentation") });
      </script>
   </div>
   <!-- Optional JavaScript -->
   <!-- jQuery first, then Popper.js, then Bootstrap JS -->
   <script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" crossorigin="anonymous">
   </script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" crossorigin="anonymous">
   </script>
   <script>
      //on d??tecte la pr??sence de la souris sur une ??toile
      $(".tde").mouseover(function(){

         //Gr??ce ?? substring(), on r??cup??re le num??ro dans l'id de cette ??toile et on la stocke dans une variable en ayant supprim?? le pr??fixe "tde_", bonnes pratiques du HTML !
         var nbr = $(this).prop('id').substring(4);

         //on impose la couleur jaune dans le fond transparent de cette ??toile
         $(this).css( "backgroundColor", "#E0E001" );

         //et en m??me temps, on met toutes les ??toiles en-dessous de nbr en jaune.
         $(".tde").slice(0, nbr).css( "backgroundColor", "#E0E001" );

         //et toutes celles au-dessus de nbr en gris
         $(".tde").slice(nbr).css( "backgroundColor", "#A1A1A1" );
      })

      // on d??tecte la pr??sence de la souris sur une ??toile
      // Faire de l'AJAX ICI
      $(".tde").onclick(function(){
         var nbr = $(this).prop('id').substring(4);
         alert(nbr);
      })

      //et quand la souris s'en va, on annule le fond jaune sous les ??toiles pour garder uniquement celui de #value 
      $("#glob").mouseout(function(){
         $(".tde").css('backgroundColor', "" );
      })
   </script>
</body>

</html>