<?php
session_start(); //démarre la session
require_once('fonctions/connect.php');
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <title>Foundation Phoenix - Targets</title>
  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/reset.css" />
  <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body>
  <?php include '_partials/_header.php'; ?>
  <?php include '_partials/_messages.php'; ?>
  <div class="container">
  <div class="h2 text-center mt-4"> Targets </div>
    <div class="card-deck">
      <?php
      // On récupère les targets
      $targets = $con->query('SELECT * FROM targets');
      // On affiche chaque entrée une à une
      while ($target = $targets->fetch()) {
        $date = new DateTime($target['birthdate']);
      ?>
        <div class="card mt-4">
          <div class="card-header bg-dark">
            <h5 class="card-title"><span class="h4 text-warning"><?php echo $target['name']; ?></span></h5>
            <h6 class="card-subtitle mb-2 text-muted"><span class="h5 text-white"><?php echo $target['firstname']; ?></span></h6>
          </div>
          <div class="card-body">
            <p class="card-text"><span class=" text-decoration-underline">Code target :</span><span> <?php echo $target['code']; ?></span></p>
            <p class="card-text"><span class="text-decoration-underline">Pays de naissance :</span><span> <?php echo $target['nationality']; ?></span></p>
            <p class="card-text"><span class="text-decoration-underline">Date de naissanse :</span><span> <?php echo $date->format('d-m-Y'); ?></span></p>
          </div>
        </div>
      <?php
      }
      $targets->closeCursor(); // Termine le traitement de la requête
      ?>
    </div>
  </div>

  <!-- bootstrap js-->
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <!-- js -->
  <script src="assets/js/main.js"></script>
</body>

</html>