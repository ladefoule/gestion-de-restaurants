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
   <title>Création de restaurant</title>
</head>

<body>
   <div class="container">
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
               <!-- <li class="nav-item">
                  <a class="nav-link" href="#">Pricing</a>
               </li> -->
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
</body>

</html>